<?php
namespace App\Services\DepositOperation;


use App\Models\DepositSet;
use App\Models\OrderBasic;
use Illuminate\Support\Facades\DB;

class DepositAppLogicService
{
    
    private $setModel = null;
    private $service = null;
    private $detailService = null;
    
    public function __construct(DepositOperationService $service, DepositDetailService $detailService)
    {
        $this->setModel  = DepositSet2::getInstance();
        $this->service = $service;
        $this->detailService = $detailService;  
    }
    
    
    /**
     * 下单时返还 -- 审核通过时  扣除部分就是 = 保证金-返还
     */
    public function depositAtCheck(OrderBasic $order)
    {
        $algorithm = $this->getAlgorithm($order->type);
        $amount = $this->caculGoods($order->goods);
        try {
            DB::beginTransaction();
            $freight = $order->getDepositFreight();
            if ($this->setModel->isZero()) {
                // 扣除部分就是 =  
                $deposit = $algorithm->deposit($amount, $freight);
                if ($order->type!=4) {
                    $order->setDepositReturn();
                }
                
                $saleDeposit = $algorithm->getSaleDeposit($amount, $freight);
                $appendDeposit = $algorithm->getAppendDeposit($amount, $freight);
                
            } else {
                // 扣除部分就是 = 保证金
                $deposit = $algorithm->depositOther($amount, $freight);
                
                $saleDeposit = $algorithm->getSaleDepositOther($amount, $freight);
                $appendDeposit = $algorithm->getAppendDepositOther($amount);
            }
            
            $order->deposit = $deposit;
            if (!$order->save()) {
                throw  new \Exception('订单返还状态设置失败');
            }
            
            $this->service->subDeposit($order->department, $deposit, '订单:'.$order->order_sn);
            
            $this->detailService->setAlgorithm($algorithm);
            $this->detailService->setAmount($amount);
            $this->detailService->setDetail($order->id, $order->getDepositFreight(), $saleDeposit);
            $this->detailService->setAppendDetail($order->id,  $appendDeposit);
            
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
     * 签收时返还 京东的要另写一个
     */
    public function depositAtSign(OrderBasic $order)
    {
        //if ($this->setModel->isTwo()) {
        //返还代码
        $this->setReturn($order);
        //}
    }
    
    
    /**
     * 京东返还
     * @param unknown $order
     */
    public function jdReturn($order)
    {
        //要生成明细 明细另一个表才行
    }
    
    /**
     * 返还操作
     * @param unknown $order
     * @throws \Exception
     * @throws Exception
     */
    private function setReturn($order)
    {
        if (!$order->isDepositReturn()) {
            $algorithm = $this->getAlgorithm($order->type);
            $amount = $this->caculGoods($order->goods);
            
            $freight = $order->getDepositFreight();
            $returnDeposit = $algorithm->returnDeposit($amount, $freight);
            try {
                DB::beginTransaction();
                $this->service->returnDeposit($order->department, $returnDeposit , '订单:'.$order->order_sn );
                //设置已返还标志
                $order->setDepositReturn();
                //保存已返还的金额
                $order->return_deposit = $returnDeposit;
                if (!$order->save()) {
                    throw  new \Exception('订单返还状态设置失败');
                }
                
//                 $this->detailService->setAlgorithm($algorithm);
//                 $this->detailService->setAmount($amount);
                
                $this->detailService->setReturnDeposit($order->id, $algorithm->goodsReturn($amount->sale, $freight));
                $this->detailService->setAppendReturnDeposit($order->id, $algorithm->appendReturn($amount->append));
                
                DB::commit();
            } catch (Exception $e) {
                DB::rollback();
                throw $e;
            } 
        }
    }
    
    
    /**
     * 在某些情况下需要退回保证金
     */
    public function returnDeposit(OrderBasic $order)
    {
        try {
            DB::beginTransaction();
            // 保证金是否已返
            if ($order->isDepositReturn()) {  //是
                $this->service->returnDeposit($order->department, $order->deposit - $order->return_deposit,  '订单:'.$order->order_sn);
                $order->setDepositReturn(false);
                $order->return_deposit = 0.00;
                //                 $order->save();
                if (!$order->save()) {
                    throw  new \Exception('退还保证金失败');
                }
            } else { //还没有返
                $this->service->returnDeposit($order->department, $order->deposit);
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            throw new \Exception('退还预充值失败:'. $e->getMessage());
        }
        
    }
    
    
    public function getAlgorithm($type)
    {
        //对应 order_type 的 id
        switch ($type) {
            case 2: //内购 
                return new InnerAlgorithm(resolve('App\\Models\\DepositSet2'));
                break;
            case 3: //销售订单
                return new SaleAlgorithm(resolve('App\\Models\\DepositSet2'));
                break;
            case 4: //京东
                return new JdAlgorithm(resolve('App\\Models\\DepositSet2'));
                break;
            default :
                return new SaleAlgorithm(resolve('App\\Models\\DepositSet2'));
        }

    }
    
    /**
     * 计算商品金额 、赠品金额
     * @param unknown $orderGoods
     * @return number[]
     */
    public function caculGoods($orderGoods = null)
    {
        $orderGoods || $orderGoods = $this->goods;
        $a = ['sale'=>0, 'append'=>0];
        
        foreach ($orderGoods as $goods) {
            $not = round($goods->price * $goods->goods_number, 2);
            if ($goods->isAppendage()) {
                $a['append'] = $a['append'] + $not;
            } else {
                $a['sale'] = $a['sale'] + $not;
            }
        }
        return (object) $a;
    }
    
}
