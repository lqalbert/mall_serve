<?php
namespace App\Services\JdOrder;

use App\Models\JdOrderBasic;
use App\Models\CustomerContact;
use App\models\DeliveryAddress;
use App\Services\Inventory\InventoryService;
use App\Services\DepositOperation\DepositAppLogicService;

class JdOrderService 
{
    
    private $inventoryService = null;
    private $depositService = null;
    
    
    public function __construct(InventoryService $invenService, DepositAppLogicService $depositAppSerivce)
    {
        $this->inventoryService = $invenService;
        $this->$depositService = $depositAppSerivce;
    }
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
                    $this->inventoryService->jdOrder($order->entrepot, $order->goods, auth()->user(), $order->order_sn);
                    //计算账面运费
                    $addressModel = $order->address;
                    $order->book_freight = $this->calculateBookFreight($addressModel->address);
                    $order->save();
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
    
    
    /**
     * 计算账面运费
     * 硬编码
     */
    private function calculateBookFreight($address)
    {
        // 新疆 // 宁夏 青海省 西藏自治区
//         mb_strpos
        $arr = ['新疆', '宁夏','清海','西藏'];
        foreach ($arr as $value) {
            if (mb_strpos($address, $value) ==0) {
                return 18;
            }
        }
        return 10;
    }
    
    
}