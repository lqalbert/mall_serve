<?php

namespace App\Http\Controllers\Admin;

use App\models\DeliveryAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Events\ContactConflict;
use App\Models\CustomerTrackLog;
use Illuminate\Validation\ValidationException;

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

        $user = auth()->user();
//         try {
//             $this->validate($request, [
//                 'fixed_telephone' => ['nullable', 'unique:delivery_addresses'],
//             ]);
//         } catch (ValidationException $e) {
//             $fixed_telephone = $request->input('fixed_telephone');
//             $data = [];
//             $data['cus_id'] = DB::table('delivery_addresses')->where('fixed_telephone', $fixed_telephone)->value('cus_id');
//             $data['cus_name'] = DB::table('customer_basic')->where('id', $data['cus_id'])->value('name');
//             $data['user_id'] = $user->toArray()['id'];
//             $data['user_name'] = $user->toArray()['realname'];
//             $data['content'] = '添加收货地址时与手机号码' . $fixed_telephone . '冲突';
//             $re = CustomerTrackLog::create($data);
//             if ($re) {
// //                event(new ContactConflict($e->validator->errors(), $request->only(['fixed_telephone'])));
//                 throw $e;
//             }
//         }
        if ($request->default_address == 1) {
            $this->model->where('cus_id', $request->cus_id)->update(['default_address' => 0]);
        }
        $re = $this->model->create($request->all());

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
        return $this->success([]);
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
