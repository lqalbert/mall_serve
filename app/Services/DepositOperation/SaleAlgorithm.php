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
    public function goodsReturn($amount,$freight) //$freight占位
    {
        return $this->calculate($amount, 1 - $this->setModel->getYk()- $this->setModel->getC());
    }
    
    /**
     * 赠品返还
     */
    public function appendReturn($amount)
    {
        return round($this->calculate($amount, $this->setModel->getZn() * ( 1 - $this->setModel->getYz() )) - $this->setModel->getC()*$amount,2);
    }
    
    /**
     * 即时返还 扣除
     */
    public function deposit(\stdClass $amount, $freight)
    {
        return round($this->goodsDeposit($amount->sale) + $this->appendDeposit($amount->append) + $this->entrepotDeposit($amount) + $freight,2);
    }
    
    
    /**
     * 其它返还 扣除
     */
    public function depositOther(\stdClass $amount, $freight)
    {
        return round($amount->sale + $this->appendDiscounted($amount->append) + $freight,2);
    }
    
    /**
     * 返还
     */
    public function returnDeposit($amount,$freight) //$freight 没用只是为以参数占位)
    {
        
        return round($this->goodsReturn($amount->sale,0) + $this->appendReturn($amount->append), 2);
    }
    
    
    /**
     * 即时返还
     * depositdetail用的获取商品的扣除
     */
    public function getSaleDeposit(\stdClass $amount, $freight)
    {
        return round($this->goodsDeposit($amount->sale)  + $this->entrepotDepositItem($amount->sale) + $freight,2);
    }
    
    /**
     * 即时返还
     * depositdetail用的获取赠品的扣除
     */
    public function getAppendDeposit(\stdClass $amount)
    {
        return $this->appendDeposit($amount->append) + $this->entrepotDepositItem($amount->append);
    }
    
    /**
     * 其它返还 
     * depositdetail用的获取商品的扣除
     */
    public function getSaleDepositOther(\stdClass $amount, $freight)
    {
        return round($amount->sale + $freight,2);
    }
    
    /**
     * 其它返还
     * depositdetail用的获取赠品的扣除
     */
    public function getAppendDepositOther(\stdClass $amount)
    {
        return $this->appendDiscounted($amount->append);
    }
    
    
    
}