<?php
namespace App\Services\JdOrder;

use App\Models\JdOrderBasic;
use App\Models\CustomerContact;
use App\models\DeliveryAddress;
use App\Services\Inventory\InventoryService;
use App\Services\DepositOperation\DepositAppLogicService;
use App\Models\FreightExtra;
use App\Models\AreaInfo;
use App\Models\CustomerUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

class JdOrderService 
{
    
    private $inventoryService = null;
    private $depositService = null;
    
    
    public function __construct(InventoryService $invenService, DepositAppLogicService $depositAppSerivce)
    {
        $this->inventoryService = $invenService;
        $this->depositService = $depositAppSerivce;
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
                
                if ($order->isNoSence()) {
                    continue;
                }
                DB::beginTransaction();
                //匹配
                $re = $this->matchOrderEmployee($order);
                if ($re) {
//                     $order->setMatchState();
                    $this->inventoryAndDeposit($order);
                    //扣库存;
//                     $this->inventoryService->jdOrder($order->entrepot, $order->goods, auth()->user(), $order->order_sn);
                    
//                     $order->is_deduce_inventory = 1;
//                     $addressModel = $order->address;
//                     //计算账面运费
//                     $order->book_freight = $this->calculateBookFreight($addressModel->address);
// //                     $order->save();
//                     //返还
//                     $this->depositService->jdReturn($order);
                } else {
                    $order->setMatchState(false);
                    $order->save();
                }
                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
                $order->setMatchState(false);
                $order->save();
                continue;
            }
        }
    }
    
    public function manuMatch($orders)
    {
        try {
            foreach ($orders as $order) {
                if ($order->isNoSence()) {
                    continue;
                }
                $this->inventoryAndDeposit($order);
                
//                 $this->inventoryService->jdOrder($order->entrepot, $order->goods, auth()->user(), $order->order_sn);
//                 //计算账面运费
//                 $order->is_deduce_inventory = 1;
//                 $addressModel = $order->address;
//                 $order->book_freight = $this->calculateBookFreight($addressModel->address);
//                 //                     $order->save();
//                 //返还
//                 $this->depositService->jdReturn($order);
            }
        } catch (\Exception $e) {
            
            throw  $e;
//             continue;
        }
    }
    
    /**
     * 退回库存
     * @param JdOrderBasic $order
     * @throws \Exception
     * @throws Exception
     */
    public function returnInventory(JdOrderBasic $order)
    {
        if (!$order->isReturnInventory()) {
            return ;
        }
        try {
            DB::beginTransaction();
            $service->jdOrder($order->entrepot, $order->goods, auth()->user(), $order->order_sn,false);
            $order->setduceInventory(false);
            //             logger('[db]',[$order->is_deduce_inventory]);
            $re = $order->save();
            if (!$re) {
                throw new \Exception('退回失败');
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
    
    /**
     * 退回 返还
     * @param JdOrderBasic $order
     * @return unknown
     */
    public function returnDeposit(JdOrderBasic $order)
    {
        if (!$order->isDepositReturn()) {
            return ;
        }
        $serve = $this->depositService->getOperator();
        $serve->subDeposit($order->department, $order->return_deposit, '退回返还 订单:JD'.$order->order_sn);
        $order->setDepositReturn(false);
        $order->return_deposit=0.00;
        $re = $order->save();
        if (!$re) {
            throw new \Exception('退回返还失败');
        }
    }
    
    /**
     * 取消匹配
     * @param Collection $orders
     */
    public function cancleMatch(Collection $orders)
    {
        try {
            DB::beginTransaction();
            // user_id group_id department_id 需要改为0 match_state 为0
            $ids = $orders->pluck('id');
            $re = DB::table('jd_order_basic')
                  ->whereIn('id', $ids)
                  ->update(['user_id'=>0,'group_id'=>0,'department_id'=>0,'match_state'=>0]);
            if (0 == $re) {
                throw new \Exception('更新订单匹配状态失败');
            }
            //退回京东返还 
            foreach ($orders as $order) {
                $this->returnDeposit($order);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
    
    private function inventoryAndDeposit($order)
    {
        //扣库存
        if (!$order->isReturnInventory()) {
            $this->inventoryService->jdOrder($order->entrepot, $order->goods, auth()->user(), $order->order_sn);
            $order->setduceInventory();
            $order->save();
        }
        
        //计算账面运费
        if (empty(intval($order->book_freight))) {
            $addressModel = $order->address;
            $order->book_freight = $this->calculateBookFreight($addressModel->address);
        }
        
        //                     $order->save();
        //返还
        if (!$order->isDepositReturn()) {
            $this->depositService->jdReturn($order);
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
        $model->setMatchState();
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
//         $arr = ['新疆', '宁夏','清海','西藏','内蒙'];
        $arr = $this->getArea();
        foreach ($arr as $value) {
            if (mb_strpos($address, $value) === 0) {
                return 18;
            }
        }
        return 10;
    }
    /**
     * 偏远地区
     */
    private function getArea()
    {
        $re = FreightExtra::where('fr_id',1)->pluck('province_id');
        if ($re->isEmpty()) {
            return [];
        } else {
            $area = AreaInfo::whereIn('id', $re->toArray())->pluck('name');
            return $area->map(function ($item, $key) {
                return mb_substr($item, 0,2);
            });
        }
    }
    
    
}