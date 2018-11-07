<?php
namespace App\Services\DepositOperation;

/**
 * 销售订单 的扣除 返还计算
 * @author hyf
 *
 */
class InnerAlgorithm extends AbstractAlgorithm
{
   
     
    public function goodsDiscounted($amount)
    {
        return $this->calculate($amount, $this->setModel->getN());
    }
    
    /**
     * 商品返还
     */
    public function goodsReturn($amount, $freight) // $freight 占位
    {
        return round($this->goodsDiscounted($amount) - $this->goodsDeposit($amount) - $this->entrepotDepositItem($amount), 2);
    }
    
    /**
     * 赠品返还
     */
    public function appendReturn($amount)
    {
        return 0;
    }
    
    /**
     * 即时返还 扣除
     */
    public function deposit(\stdClass $amount, $freight)
    {
        return round($this->goodsDeposit($amount->sale) + $this->entrepotDeposit($amount) + $freight,2);
    }
    
    
    /**
     * 其它返还 扣除
     */
    public function depositOther(\stdClass $amount, $freight)
    {
        return round($this->goodsDiscounted($amount->sale)+ $freight,2);
    }
    
    /**
     * 返还
     */
    public function returnDeposit($amount, $freight) //$freight 没用只是为以参数占位
    {
        //商品金额*N - 商品扣除 - 仓储扣除
        return round($this->goodsDiscounted($amount->sale) - $this->goodsDeposit($amount->sale) - $this->entrepotDepositItem($amount->sale), 2);
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
        return 0;
    }
    
    /**
     * 其它返还
     * depositdetail用的获取商品的扣除
     */
    public function getSaleDepositOther(\stdClass $amount, $freight)
    {
        return round($this->goodsDiscounted($amount->sale) + $freight,2);
    }
    
    /**
     * 其它返还
     * depositdetail用的获取赠品的扣除
     */
    public function getAppendDepositOther(\stdClass $amount)
    {
        return 0;
    }
    
}