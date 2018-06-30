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
        if($request->input('cus_id')){
            $data=$this->model->where('cus_id','=',$request->input('cus_id'))->get();
        }
        else{
            $data=$this->model->where('id','=',$request->input('address_id'))->get();
        }
//         $address=[];
//         $full_address=[];
//         foreach ($data as $k => $v){
//             $address[$v->id]=$v;
//             $full_address[$k]['id']=$v->id;
//             // $full_address[$k]['fullAddress']=$v->name.'-'.$v->phone.'-'.$v->zip_code.'-'.$v->address;
//             $fullAddress=$v->area_province_name.$v->area_city_name.$v->area_district_name.'-'.$v->name.'-'.$v->fixed_telephone;
//             $full_address[$k]['fullAddress']=$fullAddress;
//         }
        return ['items'=>$data];
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
        if($request->default_address == 1){
            $this->model->where('cus_id',$request->cus_id)->update(['default_address' => 0]);
        }
       $re =  $this->model->create($request->all());
       
       if ($re) {
           return $this->success([]);
       } else {
           return $this->error();
       }
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
        if($request->default_address == 1){
            $this->model->where('cus_id',$request->cus_id)->update(['default_address' => 0]);
        }
        $this->model->where('id','=',$id)->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\models\DeliveryAddress  $deliveryAddress
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $this->model->destroy($id);
    }
}
