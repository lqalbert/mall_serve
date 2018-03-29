<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Assign;
class DistributionDeliveryTabPaneController extends Controller
{

    public function index(Request $request)
    {

        $id = $request->all()['id'];
       $data  = Assign::join('goods_basic','goods_basic.sku_sn','=','assign_basic.sku_sn')
            ->where('assign_basic.id',$id)
            ->select('assign_basic.*','goods_basic.goods_price')
            ->first()->toArray();
//       var_dump($data);die();
            $delivery_details_data=[];
            $delivery_addresses_data=[];
            $communication_data=[];

            //        获取发货明细
            $delivery_details_data['goods_name']=$data['goods_name'];
            $delivery_details_data['goods_num']=$data['goods_num'];
            $delivery_details_data['cate_kind']=$data['cate_kind'];
            $delivery_details_data['weight']=$data['weight'];
            $delivery_details_data['goods_price']=$data['goods_price'];

            //        获取收货人地址
            $delivery_addresses_data['deliver_name']=$data['deliver_name'];
            $delivery_addresses_data['deliver_phone']=$data['deliver_phone'];
            $delivery_addresses_data['deliver_address']=$data['deliver_address'];

            //        获取沟通联系
            $communication_data['cus_name']=$data['cus_name'];
            $communication_data['user_name']=$data['user_name'];
            $communication_data['contact_content']=$data['contact_content'];
            $communication_data['contact_content_time']=$data['contact_content_time'];
            //        获取操作记录

            $operation_data=[];
            if($data['sign_at']){

                $operation_data1['type_name']='签收';
                $operation_data1['user_name']=$data['user_name'];
                $operation_data1['time']=$data['sign_at'];
                $operation_data[]=$operation_data1;

            }
            if($data['communicate_time']){

                $operation_data2['type_name']='沟通';
                $operation_data2['user_name']=$data['user_name'];
                $operation_data2['time']=$data['communicate_time'];
                $operation_data[]=$operation_data2;

            }
            if($data['send_time']){
                $operation_data3['type_name']='发货';
                $operation_data3['user_name']=$data['user_name'];
                $operation_data3['time']=$data['send_time'];
                $operation_data[]=$operation_data3;
            }
            if($data['edit_time']){
                $operation_data4['type_name']='修改';
                $operation_data4['user_name']=$data['user_name'];
                $operation_data4['time']=$data['edit_time'];
                $operation_data[]=$operation_data4;
            }
            if($data['waste_time']){
                $operation_data5['type_name']='废单';
                $operation_data5['user_name']=$data['user_name'];
                $operation_data5['time']=$data['waste_time'];
                $operation_data[]=$operation_data5;
            }
            if($data['edit_address_time']){
                $operation_data6['type_name']='修改地址';
                $operation_data6['user_name']=$data['user_name'];
                $operation_data6['time']=$data['edit_address_time'];
                $operation_data[]=$operation_data6;
            }



            return [
                'delivery_details_data'=>array($delivery_details_data),
                'delivery_addresses_data'=>array($delivery_addresses_data),
                'communication_data'=>array($communication_data),
                'operation_data'=>array($operation_data),
            ];



    }


}
