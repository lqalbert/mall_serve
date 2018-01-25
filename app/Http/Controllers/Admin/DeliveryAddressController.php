<?php

namespace App\Http\Controllers\Admin;

use App\models\DeliveryAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeliveryAddressController extends Controller
{


    private $model = null;
    public function  __construct(DeliveryAddress $DeliveryAddress)
    {
        $this->model = $DeliveryAddress;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data=$this->model->where('cus_id','=',$request->cus_id)->get();
        $address=[];
        foreach ($data as $k => $v){
            $address[$v->id]=$v;
        }
        return ['items'=>$data,'address'=>$address];
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
        $this->model->cus_id = $request->cus_id;
        $this->model->phone = $request->phone;
        $this->model->name = $request->name;
        $this->model->address = $request->address;
        $this->model->default_address = $request->default_address;
        $this->model->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\models\DeliveryAddress  $deliveryAddress
     * @return \Illuminate\Http\Response
     */
    public function show(DeliveryAddress $deliveryAddress)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\models\DeliveryAddress  $deliveryAddress
     * @return \Illuminate\Http\Response
     */
    public function edit(DeliveryAddress $deliveryAddress)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\models\DeliveryAddress  $deliveryAddress
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $data=[
             'name'=>$request->name,
             'phone'=>$request->phone,
             'address'=>$request->address,
             'default_address'=>$request->default_address,
        ];
        $this->model->where('id','=',$id)->update($data);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\models\DeliveryAddress  $deliveryAddress
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeliveryAddress $deliveryAddress,Request $request,$id)
    {

        $this->model->destroy($id);
    }
}
