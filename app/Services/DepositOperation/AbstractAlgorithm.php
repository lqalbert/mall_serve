<?php
namespace App\Services\DepositOperation;

/**
 * 销售订单 的扣除 返还计算
 * @author hyf
 *
 */
abstract class AbstractAlgorithm
{
    
    
    protected $setModel = null;
    
    public function __construct(DepositParam $model)
    {
        $this->setModel = $model;
    }
    
    public function calculate($amount, $x)
    {
        return round($amount * $x, 2);
    }
    
    /**
     * 商品扣除
     * @param unknown $amount
     * @return number
     */
    public function goodsDeposit($amount)
    {
        return $this->calculate($amount, $this->setModel->getYk());
    }
    
    
    /**
     * 仓库扣除 注意如果为内购订单 $amount->append 应该为0
     * @param unknown $amount
     * @return number
     */
    public function entrepotDeposit($amount)
    {
        $saleDeposit = $this->entrepotDepositItem($amount->sal); 
        $appendDeposit = $this->entrepotDepositItem($amount->append);  
        return  $saleDeposit + $appendDeposit;
    }
    
    /**
     * 仓库扣除 单项计算
     * @param unknown $amount
     * @return number
     */
    public function entrepotDepositItem($amount)
    {
        return $this->calculate($amount, $this->setModel->getC());
    }
    
    /**
     * 京东的要覆盖这个方法
     * @return number
     */
    public function thirdPartDeposit($amount)
    {
        return 0;
    }

    
   
    
    
    
   
    
}