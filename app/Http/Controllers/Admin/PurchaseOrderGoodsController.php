<?php

namespace App\Http\Controllers\Admin;

use App\Models\PurchaseOrderGoods;
use Illuminate\Http\Request;

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
    public function update(Request $request, PurchaseOrderGoods $purchaseOrderGoods)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PurchaseOrderGoods  $purchaseOrderGoods
     * @return \Illuminate\Http\Response
     */
    public function destroy(PurchaseOrderGoods $purchaseOrderGoods)
    {
        //
    }
}
