<?php

namespace App\Http\Controllers\Admin;

use App\Models\ActualDeliveryExpress;
use App\Models\ActualDeliveryGoods;
use App\Models\PurchaseOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActualDeliveryExpressController extends Controller
{
    private $model = null;

    public function  __construct(ActualDeliveryExpress $ActualDeliveryExpress)
    {
        $this->model = $ActualDeliveryExpress;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $where=[];
        if($request->has('purchase_order_id')){
            $where['purchase_order_id']=$request->input('purchase_order_id');
        }
        $data = $this->model->where($where)->get();
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
        DB::beginTransaction();
        try {
            $allData = $request->all();
            $total_case_num= null;
            foreach($request->deliverGoodsList as $v){
                $total_case_num += $v['goods_case_num'];//纸箱总数
            }
            $allData['purchase_order_id']= $request->input('id');
            $allData['total_case_num']= $total_case_num;
            $actualDeliveryExpressModel = ActualDeliveryExpress::make($allData);
            $re = $actualDeliveryExpressModel->save();
            if (!$re) {
                throw new  \Exception('添加失败');
            }
            $orderGoodsModels = [];

            foreach ($request->deliverGoodsList as $k => $goods) {
                if(empty($goods['actual_goods_num'])){
                    unset($goods);
                }else{
                    $goods['express_num'] = $request->input('express_num');
                    $goods['purchase_order_id'] = $request->input('id');
                    $orderGoodsModels[] = ActualDeliveryGoods::make($goods);
                }
            }
            if (!empty($orderGoodsModels)) {
               $re1 = $actualDeliveryExpressModel->ActualGoods()->saveMany($orderGoodsModels);
            }
            $PurchaseOrderModel = new PurchaseOrder;
            $re2 = $PurchaseOrderModel->where(['id'=>$request->input('id')])->update(['purchase_status'=>3]);
            if($re && $re1 && $re2){
                DB::commit();
            }
        } catch (\Exception $e) {
            DB::rollback();
            return  $this->error([], $e->getMessage());
        }

        return $this->success([$actualDeliveryExpressModel->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ActualDeliveryExpress  $actualDeliveryExpress
     * @return \Illuminate\Http\Response
     */
    public function show(ActualDeliveryExpress $actualDeliveryExpress)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ActualDeliveryExpress  $actualDeliveryExpress
     * @return \Illuminate\Http\Response
     */
    public function edit(ActualDeliveryExpress $actualDeliveryExpress)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ActualDeliveryExpress  $actualDeliveryExpress
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ActualDeliveryExpress $actualDeliveryExpress)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ActualDeliveryExpress  $actualDeliveryExpress
     * @return \Illuminate\Http\Response
     */
    public function destroy(ActualDeliveryExpress $actualDeliveryExpress)
    {
        //
    }
}
