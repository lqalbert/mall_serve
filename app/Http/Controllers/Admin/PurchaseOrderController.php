<?php

namespace App\Http\Controllers\Admin;

use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderGoods;
use App\Models\GoodsDetails;
use App\Models\ActualDeliveryGoods;
use App\Alg\Sn;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\Inventory\InventoryService;

class PurchaseOrderController extends Controller
{


    private $model = null;

    public function  __construct(PurchaseOrder $PurchaseOrder, InventoryService $serve)
    {
        $this->model = $PurchaseOrder;
        $this->serve = $serve;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $where=[];
        if($request->has('order_sn')){
            $where['order_sn']=$request->input('order_sn');
        }
        if($request->has('entrepot_id')){
            $where['entrepot_id']=$request->input('entrepot_id');
        }
        if($request->has('shipper')){
            $where['shipper']=$request->input('shipper');
        }
        if($request->has('purchase_status')){
            $where['purchase_status']=$request->input('purchase_status');
        }
        if($request->has('warehousing_status')){
            $where['warehousing_status']=$request->input('warehousing_status');
        }
        if($request->has('settlement_status')){
            $where['settlement_status']=$request->input('settlement_status');
        }
        $data = $this->model->where($where)->get();
        $data->load('goods','actual_delivery_goods');
        $data = $data->toArray();
        return ['items'=>$data,'total'=>count($data)];

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
        if($request->input('sign')){
            
            return $this->signGoods($request);
        }
        else{
            DB::beginTransaction();
            try {
                $allData = $request->all();
                $order_sn = 'CG'.date('YmdHis');
                $allData['order_sn'] = $order_sn;
                if ($allData['entrepot_id'] == 0) {
                    throw new \Exception('没有绑定配送中心');
                }
                $orderModel = PurchaseOrder::make($allData);
                $re = $orderModel->save();
                if (!$re) {
                    throw new  \Exception('订单创建失败');
                }
                $orderGoodsModels = [];
                foreach ($request->purchase_goods as $goods) {
                    $goods['unit_type'] = GoodsDetails::getUnitTypes($goods['unit_type']);
                    $goods['goods_id'] = $goods['id'];
                    $orderGoodsModels[] = PurchaseOrderGoods::make($goods);
                }
                if (!empty($orderGoodsModels)) {
                    $orderModel->goods()->saveMany($orderGoodsModels);
                }

                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
                return  $this->error([], $e->getMessage());
            }

            return $this->success([$orderModel->id]);
        }

    }


    public function signGoods(Request $request){
        $goodsList = $request->input('signGoodsList');
//         logger('[debug]', $goodsList);
        if (count($goodsList) == 0 ) {
            return $this->error([]);
        }
        
        $goodsModels = [];
        foreach ($goodsList as $goods) {
            $goodsModels[] = ActualDeliveryGoods::make($goods);
        }
        
        $entrepot = $goodsModels[0]->purchase->entrepot;
        
        try {
            $this->serve->entryUpdate($entrepot, $goodsModels, auth()->user());
        } catch (\Exception $e) {
            
            return $this->error([], $e->getMessage());
        }
        
        return $this->success([]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PurchaseOrder  $purchaseOrder
     * @return \Illuminate\Http\Response
     */
    public function show(PurchaseOrder $purchaseOrder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PurchaseOrder  $purchaseOrder
     * @return \Illuminate\Http\Response
     */
    public function edit(PurchaseOrder $purchaseOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PurchaseOrder  $purchaseOrder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        if(!$request->has('status')){//确认订单修改
            DB::beginTransaction();
            try {
                $data= $request->except('deliverGoodsList');
                $goods_data= $request->input('deliverGoodsList');
                foreach($goods_data as $v){
                    $data['total_case_num'] = null;
                   $data['total_case_num'] += $v['goods_case_num'];//纸箱总数
                }
                $re = $this->model->where('id','=',$id)->update($data);
//                $goods_model = new ActualDeliveryGoods();
                if (!$re) {
                    throw new  \Exception('订单修改失败');
                }
                if (!empty($goods_data)) {
                    $this->model->ActualGoods()->saveMany($goods_data);
                }
                DB::commit();
//                foreach($goods_data as $v){
//                   $goods_re = $goods_model->where('id','=',$v['id'])->update($v);
//                    if (!$goods_re) {
//                        DB::rollback();
//                    }
//                }
//                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
                return  $this->error([], $e->getMessage());
            }

//            $data= $request->except('deliverGoodsList');
//            $goods_data= $request->input('deliverGoodsList');
//            $this->model->where('id','=',$id)->update($data);
//            $goods_model = new PurchaseOrderGoods();
//            foreach($goods_data as $v){
//                $goods_model->where('id','=',$v['id'])->update($v);
//            }
        }else{//审核修改
            if($request->input('status')){
                $data['purchase_status'] = $request->input('status');
            }
            $res =$this->model->where('id','=',$id)->update($data);
            if ($res) {
                return $this->success($res);
            } else {
                return $this->error($res);
            }

        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PurchaseOrder  $purchaseOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy(PurchaseOrder $purchaseOrder)
    {
        //
    }
}
