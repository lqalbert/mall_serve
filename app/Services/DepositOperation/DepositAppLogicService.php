<?php
namespace App\Services\DepositOperation;


use App\Models\DepositSet;
use App\Models\OrderBasic;
use Illuminate\Support\Facades\DB;

class DepositAppLogicService 
{
    
    private $setModel = null;
    private $service = null;
    
    public function __construct(DepositOperationService $service)
    {
        $this->setModel  = DepositSet::getInstance();
        $this->service = $service;
    }
    
    
    /**
     * 下单时返还 -- 审核通过时  扣除部分就是 = 保证金-返还
     */
    public function depositAtCheck(OrderBasic $order)
    {
        try {
            DB::beginTransaction();
            
            if ($this->setModel->isZero()) {
                // 扣除部分就是 = 保证金-返还部分
                $deposit = $this->caculDeposit($order) - $this->caculReturn($order);
                $order->setDepositReturn();
                
            } else {
                // 扣除部分就是 = 保证金
                $deposit = $this->caculDeposit($order);
            }
            
            $order->deposit = $deposit;
            if (!$order->save()) {
                throw  new \Exception('订单返还状态设置失败');
            }

            $this->service->subDeposit($order->department, $deposit);
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
        
    }
    
    /**
     * 发货时返还 
     */
    public function depositAtSend(OrderBasic $order)
    {
        if ($this->setModel->isOne()) {
            //返还代码
            $this->setReturn($order);
        }
    }
    
    /**
     * 签收时返还
     */
    public function depositAtSign(OrderBasic $order)
    {
        //if ($this->setModel->isTwo()) {
            //返还代码
            $this->setReturn($order);
        //}
    }
    
    private function setReturn($order)
    {
        if (!$order->isDepositReturn()) {
            $returnDeposit = $this->caculReturn($order);
            try {
                DB::beginTransaction();
                $this->service->returnDeposit($order->department, $returnDeposit);
                
                $order->setDepositReturn();
                if (!$order->save()) {
                    throw  new \Exception('订单返还状态设置失败');
                }
                DB::commit();
            } catch (Exception $e) {
                DB::rollback();
                throw $e;
            } 
        }
    }
    
    
    public function caculDeposit(OrderBasic $order)
    {
        $orderGoods = $order->goods;
        //算商品价格
        if ($order->orderType->isInner()) {
            $s = $order->discounted_goods_money;;
        } else {
            $s = $this->caculGoods($orderGoods);
        }
        //算邮费
        $s = $s + $order->getDepositFreight();
        return $s;
    }
    
    public function caculReturn($order)
    {
        $orderGoods = $order->goods;
        if ($order->orderType->isInner()) {
            $s = $order->discounted_goods_money;;
        } else {
            $s = $this->caculGoods($orderGoods);
        }
//         $s = $this->caculGoods($order->goods);
        return round($s * $this->setModel->getReturn(), 2);
    }
    
    public function caculGoods($orderGoods)
    {
        $s = 0;
        foreach ($orderGoods as $goods) {
            //             $not = round($goods['price'] * $goods['goods_number'], 2);
            $not = round($goods->price * $goods->goods_number, 2);
            if ($goods->isAppendage()) {
                $rate = $this->setModel->getAppendage();
            } else {
                $rate = $this->setModel->getSale();
            }
            if ($rate != 0) {
                $not = round($not * $rate, 2);
            }
            $s = $s + $not;
        }
        return $s;
    }
}