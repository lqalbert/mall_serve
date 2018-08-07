<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\AfterSale;
use App\Models\AfterSaleGoods;
use App\Models\AfterSaleExpress;
use Illuminate\Support\Facades\DB;
use App\Events\AddAfterSale;
use App\Alg\ModelCollection;
use App\Models\OrderGoods;
use App\Models\CustomerBasic;
use Carbon\Carbon;
use App\Models\Assign;
use App\Services\Inventory\InventoryService;
use App\Events\AddOrderOperationLog;

class AfterSaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $builder = new AfterSale();
        
//         if ($request->has('express_sn')) {
//             $express_sn = $request->input('express_sn');
//             $builder = $builder->whereHas('express', function($query) use($express_sn) {
//                 $query->where('express_sn', $express_sn);
//             });
//         }
        
        if ($request->has('order_sn')) {
            $builder = $builder->where('order_sn', $request->input('order_sn'));
        }
        
        if ($request->has('return_sn')) {
            $builder = $builder->where('return_sn', $request->input('return_sn'));
        }
        
        if ($request->has('type')) {
            $builder = $builder->where('type', $request->input('type'));
        }
        
        $result = $builder->paginate($request->input('pageSize', 20));
        
        $collection = $result->getCollection();
        
        if ($request->has('appends')) {
            ModelCollection::setAppends($collection, $request->input('appends'));
        }
        
        // if ($request->has('load')) {
        //     $collection->load($request->input('load'));
        // }
        $collection->load($request->input('load','order'));
        
        return [
            'items' => $collection,
            'total' => $result->total()
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //加验证
        DB::beginTransaction();
        try {
            
            $model = AfterSale::create($request->all());
            
            $goods =  [];
            foreach ($request->input('goods', []) as $product) {
//                 $goods[] = AfterSaleGoods::make($product);
                    $id = $product['id'];
                    unset($product['id']);
                    unset($product['goods_num']);
                    OrderGoods::where('id', $id)
                                ->update($product);
                    
            }
            
            //添加订单操作记录事件
            $dataLog = [
                'order_id'=>$request->order_id,
                'action'=>'after-sale',
                'remark'=>$request->order_sn
            ];
            event(new AddOrderOperationLog(auth()->user(),$dataLog));
            
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return $this->error([], $e->getMessage());
        }
        
        return $this->success([]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // $re = AfterSale::where('id', $id)->update($request->all());
        // event( new AddAfterSale(AfterSale::find($id)));
        DB::beginTransaction();
        try {
            
            $model = AfterSale::where('id', $id)->update($request->except('goods'));

            if(!$model){
                DB::rollback();
                throw new  \Exception('失败');
            }

            foreach ($request->input('goods', []) as $product) {
                    $id = $product['id'];
                    unset($product['id']);
                    unset($product['goods_num']);
                    OrderGoods::where('id', $id)->update($product);    
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return $this->error([], $e->getMessage());
        }
        
        return $this->success([]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * [checkStatus 审核]
     * @param  Request $request [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function checkStatus(Request $request,$id){
        $data = $request->all();
        $data['check_at'] = Carbon::now();
        $re = AfterSale::where('id', $id)->update($data);
        if($re){
            return $this->success([]);
        }else{
            return $this->error([]);
        }

    }

    /**
     * [sureStatus 确认]
     * @param  Request $request [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function sureStatus(Request $request,$id){
//         $data = $request->all();
//         $data['sure_at'] = Carbon::now();

        DB::beginTransaction();
        try {
            $model = AfterSale::find($id);
            $model->setSure();
            $re = $model->save();
            
            $goods = $model->goods;
            $exchangeGoods = $goods->filter(function($value){
                return $value->isExchange();
            });
            if ($exchangeGoods->count() > 0) {
                //生成发货单;
                //库存修改
                //先临时这么写
                $data = [
                    'entrepot_id'=> $model->entrepot_id,
                    'order_id'   => $model->order_id,
                    'address_id' => $model->order->address_id,
                ];
                $assignmodel = Assign::create($data);
                $newGoods = [];
                foreach ($exchangeGoods as $xGoods){
                    $newModel = $xGoods->replicate();
                    $newModel->setExchangeStatus();
                    $newModel->save();
                    $newGoods[]  = $newModel;
                }

                $service = new InventoryService();
                $service->exLock($model->order->entrepot, $newGoods, auth()->user(), $model->return_sn);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return $this->error($e->getMessage());
        }
        if($re){
            return $this->success([]);
        }else{
            return $this->error([]);
        }
    }

    /**
     * [getCusAllInfo 获取客户相关信息]
     * @param  Request $request [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function getCusAllInfo(Request $request,$id){
        $result = CustomerBasic::where('id',$id)->get();
        // ModelCollection::setAppends($result,['type_text','source_text']);
        $result = $result->map(function ($res){
            return $res->setAppends(['type_text','source_text']);
        }); 
        $result->load('contacts','midRelative','province');
        $re = $result->toArray();
        return [
            'items'=> $re,
            'total'=> $result->count()
        ];
    }
    
    public function inventory(Request $request, InventoryService $serve, $id)
    {
//         $id = $request->input('id');
        $after = AfterSale::find($id);
        $goods = OrderGoods::where('order_id', $after->order_id)->after()->get();
        //商品
        try {
            $serve->rxUpdate($after->entrepot, $goods, $request->user(), $after->return_sn);
            $after->setInventoryed();
            $after->save();
        } catch (\Exception $e) {
            return $this->error([], $e->getMessage());
        }
        return $this->success([]);
    }




}
