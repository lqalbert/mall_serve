<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Efficacy;
use App\Alg\ModelCollection;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\OrderBasic;
use App\Events\AddOrder;
use App\Events\OrderPass;
use App\Events\OrderCancel;
use App\Events\AddOrderOperationLog;
use App\Models\OrderGoods;
use App\Models\OrderAddress;
use App\Models\GoodsDetails;
use App\Models\CombinationGoods;

class EfficacyController extends Controller
{

    private $model = null;

    public function  __construct(Efficacy $efficacy)
    {
        $this->model = $efficacy;

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	/*public function index(Request $request)
    {
        $query = Efficacy::orderBy('id', 'desc');
        
        if ($request->has('name')){
        	$query->where('name','like', "%".$request->input('name')."%");
        }
        if ($request->has('key_words')){
            $query->where('key_words','like', "%".$request->input('key_words')."%");
        }
        if ($request->has('situation')){
            $query->where('situation','like', "%".$request->input('situation')."%");
        }

        
        $re = $query->paginate(15);
        
        return [
    		'items' => $re->items(),
    		'total' => $re->total()
        ];
    }*/
    public function index(Request $request)
    {
        $where=[];
        if ($request->has('name')){
            $where[]=['name','like',"%".$request->input('name')."%"];
        }
        if ($request->has('key_words')){
            $where[]=['key_words','like',"%".$request->input('key_words')."%"];
        }
        if ($request->has('situation')){
            $where[]=['situation','like',"%".$request->input('situation')."%"];
        }

        $this->model = $this->model->with('user')->orderBy('id','desc');
        $result = $this->model->where($where)->paginate($request->input('pageSize'));
        $collection = $result->getCollection();
        if ($request->has('appends')) {
            $collection = ModelCollection::setAppends($collection, $request->input('appends'));
        }
        return ['items' => $collection->toArray(), 'total' => $result->total()];
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
        $allData = $request->all();
        $res=DB::table("efficacy")->where('plan_id',$allData['plan_id'])->get()->toArray();
        if(!empty($res)){
            return  $this->error([],'该方案编号已存在');
        }else{
            DB::beginTransaction();
            try {
                foreach ($allData['combination_goods'] as $key=>&$val){
                    $val['plan_id'] = $allData['plan_id'];
                    $val['created_at'] = date("Y-m-d H:i:s",time());
                    $val['updated_at'] = date("Y-m-d H:i:s",time());
                }
                $res1 = DB::table('combination_goods')->insert($allData['combination_goods']);
                unset($allData['combination_goods']);
                $res2 = DB::table('efficacy')->insert($allData);
                if($res1 && $res2){
                    DB::commit();
                    return  $this->success([], '操作成功');
                }
            } catch (\Exception $e) {
                DB::rollback();
                return  $this->error([], $e->getMessage());
            }
        }

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
        $allData = $request->all();
        DB::beginTransaction();
        try {
            $efficacy = Efficacy::find($id);
            $efficacy->name = $request->input('name');
            $efficacy->key_words = $request->input('key_words');
            $efficacy->situation = $request->input('situation');
            $efficacy->suggestion = $request->input('suggestion');
            $res1 = $efficacy->save();
            $ids=DB::table("combination_goods")->where('plan_id',$allData['plan_id'])->get()->map(function ($value) {
                return (array)$value;
            })->toArray();
            foreach($ids as $v){
                DB::table('combination_goods')->where('id',$v['id'])->delete();
            }
            $arr = [];
            foreach ($allData['combination_goods'] as $key=>$val){
                $arr[$key]['plan_id'] = $val['plan_id'];
                $arr[$key]['type'] = $val['type'];
                $arr[$key]['name'] = $val['name'];
                $arr[$key]['number'] = $val['number'];
            }
            $res2 = DB::table('combination_goods')->insert($arr);
            if($res1 && $res2){
                DB::commit();
                return  $this->success([], '操作成功');
            }
        } catch (\Exception $e) {
            DB::rollback();
            return  $this->error([], $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $re = Efficacy::destroy($id);
        if ($re) {
        	return $this->success($re);
        } else {
        	return $this->error($re);
        }
    }


    public function depositDetail($plan_id)
    {
        $re=DB::table("combination_goods")->where('plan_id',$plan_id)->get()->toArray();
        $newRe = [];
        foreach ($re as $key=>$val){
            $res=Db::table('goods_basic')->where('id',$val->name)->get()->map(function ($value) {
                return (array)$value;
            })->toArray();
            $val->efficacy = $res[0]['efficacy'];
            $val->realname = $res[0]['goods_name'];
            $val->sku_sn = $res[0]['sku_sn'];
            $newRe[$key] = $val;
        }
        return $newRe;
    }

    public function efficacyDetail(Request $request)
    {
        $arr = $request->all();
        if(!$arr['name'] && !$arr['key_words']){
            return ['items' => []];
        }else{
            $where=[];
            if ($request->has('name')){
                $where[]=['name','like',"%".$request->input('name')."%"];
            }
            if ($request->has('key_words')){
                $where[]=['key_words','like',"%".$request->input('key_words')."%"];
            }

            $this->model = $this->model->with('user')->orderBy('id','desc');
            $result = $this->model->where($where)->paginate(100);
            $collection = $result->getCollection();
            if ($request->has('appends')) {
                $collection = ModelCollection::setAppends($collection, $request->input('appends'));
            }
            return ['items' => $collection->toArray()];
        }
    }

    /**
     * @param Request $request
     * @return array
     */
    public function efficacyPlan(Request $request)
    {
        $arr = $request->all();
        $this->model = $this->model->with('CombinationGoods')->orderBy('id','desc');
        $result = $this->model->where('plan_id',$arr['plan_id'])->paginate(100);
        $collection = $result->getCollection();
        if ($request->has('appends')) {
            $collection = ModelCollection::setAppends($collection, $request->input('appends'));
        }
        return ['items' => $collection->toArray()];
    }

    public function addOrder(Request $request)
    {
        DB::beginTransaction();
        try {
            $allData = $request->all();
//            pr($allData);
            $allData['entrepot_id'] = auth()->user()->getEntrepotId();//3
            if ($allData['entrepot_id'] == 0) {
                throw new \Exception('没有绑定配送中心');
            }
            //添加一些字段数据
            $user = User::findOrFail($allData['user_id']);
            $allData['user_id'] = $user->id;
            $allData['user_name'] = $user->realname;
            $orderModel = OrderBasic::make($allData);

            //内部订单 保证金就是 打折之后的金额
            /*if ($orderModel->orderType->isInner()) {
                $orderModel->deposit = $allData['discounted_goods_money'];
            }*/
//            $orderModel->typeToPlanObject();
            $re = $orderModel->save();
            if (!$re) {
                throw new  \Exception('订单创建失败');
            }
            $orderGoodsModels = [];
            foreach ($request->combination_goods as $goods) {
                $goods['unit_type'] = GoodsDetails::getUnitTypes($goods['unit_type']);
                $orderGoodsModels[] = OrderGoods::make($goods);
            }
            if (!empty($orderGoodsModels)) {
                $orderModel->goods()->saveMany($orderGoodsModels);
            }
            $address = $request->address;
            unset($address['id']);
            $address['cus_id']=$allData['cus_id'];
            //查询地址
            $res=Db::table('delivery_addresses')->where('cus_id',$allData['cus_id'])->get()->map(function ($value) {
                return (array)$value;
            })->toArray();
            $orderAddressModels = OrderAddress::make($res[0]);
            if (!empty($orderAddressModels)) {
                $orderModel->address()->save($orderAddressModels);
                $orderModel->address_id = $orderAddressModels->id;
                $orderModel->save();
            }
            event( new AddOrder($orderModel) );
            //添加订单操作记录事件
            $dataLog = [
                'order_id'=>$orderModel->id,
                'action'=>'add',
                'remark'=>$orderModel->order_sn
            ];
            event(new AddOrderOperationLog(auth()->user(),$dataLog));
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return  $this->error([], $e->getMessage());
        }

        return $this->success([$orderModel->id]);
    }






}
