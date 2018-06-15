<?php

namespace App\Http\Controllers\Admin;

use App\Models\ActualDeliveryGoods;
use Illuminate\Http\Request;

class ActualDeliveryGoodsController extends Controller
{
    private $model = null;

    public function  __construct(ActualDeliveryGoods $ActualDeliveryGoods)
    {
        $this->model = $ActualDeliveryGoods;
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
        $data = $request->all();
       $this->model->insert($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ActualDeliveryGoods  $actualDeliveryGoods
     * @return \Illuminate\Http\Response
     */
    public function show(ActualDeliveryGoods $actualDeliveryGoods)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ActualDeliveryGoods  $actualDeliveryGoods
     * @return \Illuminate\Http\Response
     */
    public function edit(ActualDeliveryGoods $actualDeliveryGoods)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ActualDeliveryGoods  $actualDeliveryGoods
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ActualDeliveryGoods $actualDeliveryGoods)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ActualDeliveryGoods  $actualDeliveryGoods
     * @return \Illuminate\Http\Response
     */
    public function destroy(ActualDeliveryGoods $actualDeliveryGoods)
    {
        //
    }
}
