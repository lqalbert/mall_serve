<?php
namespace App\Services\JdOrder;

use App\Models\JdOrderBasic;
use App\Models\CustomerContact;
use App\models\DeliveryAddress;

class JdOrderService 
{
    
    private $inventoryService = null;
    
    /**
     * 匹配
     * 匹配成功就 减库存 和 返还
     * @param [JdOrderBasic] $orders
     */
    public function match($orders)
    {
        foreach ($orders as $order) {
            try {
                //匹配
                $re = $this->matchOrderEmployee($order);
                if ($re) {
                    //扣库存;
                    $this->inventoryService->jdOrder();
                    //返还
                }
                
            } catch (Exception $e) {
                continue;
            }
        }
    }
    
    private function matchOrderEmployee(JdOrderBasic $model)
    {
        $JdCustoemr = $model->customer;
        //查看联系方式
        $cusCtModel = CustomerContact::where('phone', $JdCustoemr->tel)->first(['cus_id']);
        if($cusCtModel){ //能匹配
            $this->setOrderEmployee($model, $cusCtModel->cus_id);
            return true;
        } else { //不能
            //查看收货地址
            $readdressModel = DeliveryAddress::where('phone', $JdCustoemr->tel)
                                ->orWhere('fixed_telephone', $JdCustoemr->tel)
                                ->first(['cus_id']);
            if ($readdressModel) { //能匹配
                $this->setOrderEmployee($model, $readdressModel->cus_id);
                return true;
            }
            //不能
            return false;
        }
    }
    
    /**
     * 设置
     * @param JdOrderBasic $model
     * @param int $cus_id
     */
    private function setOrderEmployee(JdOrderBasic $model ,$cus_id)
    {
        $cusUserModel = CustomerUser::where('cus_id', $cus_id)->select('user_id','group_id','department_id','cus_id')->first();
        $cusUser = $cusUserModel->toArray();
        $cusUser['cus_id'] = $cus_id;
        $model->fill($cusUser);
//         $re = $model->save();
        if (!$model->save()) {
            throw new \Exception('设置部门小组员工失败');
        }
        
    }
    
    
}