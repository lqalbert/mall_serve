<?php

namespace App\Http\Controllers\Admin;

use App\Models\PurchaseOrderGoods;
use App\Models\PurchaseOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseOrderGoodsController extends Controller
{


    private $model = null;

    public function  __construct(PurchaseOrderGoods $PurchaseOrderGoods)
    {
        $this->model = $PurchaseOrderGoods;
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PurchaseOrderGoods  $purchaseOrderGoods
     * @return \Illuminate\Http\Response
     */
    public function show(PurchaseOrderGoods $purchaseOrderGoods)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PurchaseOrderGoods  $purchaseOrderGoods
     * @return \Illuminate\Http\Response
     */
    public function edit(PurchaseOrderGoods $purchaseOrderGoods)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PurchaseOrderGoods  $purchaseOrderGoods
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        //
        $purchaseOrderModel =  new PurchaseOrder;
        $purchaseOrderModel_data = $request->except('purchase_goods');
        $purchaseOrderModel_goods_data = $request->input('purchase_goods');

        DB::beginTransaction();
        try {
            $re = $purchaseOrderModel->where(['id'=>$id])->update($purchaseOrderModel_data);
            if (!$re) {
                throw new  \Exception('订单修改失败');
            }
            foreach ($purchaseOrderModel_goods_data as $goods) {
                $this->model->where(['id'=>$goods['id']])->update($goods);
//                $orderGoodsModels[] = PurchaseOrderGoods::make($goods);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return  $this->error([], $e->getMessage());
        }

        return $this->success([]);



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PurchaseOrderGoods  $purchaseOrderGoods
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
//        var_dump($id);die;
        $re = $this->model->destroy($id);
        if ($re) {
            return $this->success(1);
        } else {
            return $this->error(0);
        }
    }
}
