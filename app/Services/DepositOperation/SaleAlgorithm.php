<?php
namespace App\Services\DepositOperation;

/**
 * 销售订单 的扣除 返还计算
 * @author hyf
 *
 */
class SaleAlgorithm  extends AbstractAlgorithm
{
 
    /**
     * 赠品扣除
     * @param unknown $amount
     * @return number
     */
    public function appendDeposit($amount)
    {
        return $this->calculate($amount, $this->setModel->getZn() * $this->setModel->getYz());
    }
    
    
    
    public function appendDiscounted($amount)
    {
        return $this->calculate($amount, $this->setModel->getZn());
    }
    
    /**
     * 商品返还
     */
    public function goodsReturn($amount)
    {
        return $this->calculate($amount, 1 - $this->setModel->getYk()- $this->setModel->getC());
    }
    
    /**
     * 赠品返还
     */
    public function appendReturn($amount)
    {
        return $this->calculate($amount, $this->setModel->getZn() * ( 1 - $this->setModel->getYz()));
    }
    
    /**
     * 即时返还 扣除
     */
    public function deposit(Object $amount, $freight)
    {
        return rountd($this->goodsDeposit($amount->sale) + $this->appendDeposit($amount->append) + $this->entrepotDeposit($amount) + $freight,2);
    }
    
    
    /**
     * 其它返还 扣除
     */
    public function depositOther(Object $amount, $freight)
    {
        return round($amount->sale + $this->appendAmount($amount->append) + $freight,2);
    }
    
    /**
     * 返还
     */
    public function returnDeposit($amount,$freight) //$freight 没用只是为以参数占位)
    {
        
        return round($this->saleReturn($amount->sale) + $this->appendReturn($amount->append), 2);
    }
    
}