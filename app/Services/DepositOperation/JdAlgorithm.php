<?php
namespace App\Services\DepositOperation;

/**
 * 销售订单 的扣除 返还计算
 * @author hyf
 *
 */
class JdAlgorithm extends AbstractAlgorithm
{
   
    /**
     * 商品返还
     */
    public function goodsReturn($amount, $freight)
    {
        return round($amount - $this->goodsDeposit($amount) - $this->entrepotDepositItem($amount) - $this->jdDeposit($amount) - $freight, 2);
    }
    
    /**
     * 赠品返还
     */
    public function appendReturn($amount)
    {
        return 0;
    }
    
    public function jdDeposit($amount)
    {   logger('[jd]', [$this->setModel->getY()*100, $this->setModel->getJ()*100 , $this->setModel->getJ() * (1 - $this->setModel->getY())]);
        return $this->calculate($amount, round($this->setModel->getJ() * (1 - $this->setModel->getY()), 2));
    }
    
    /**
     * 京东的要覆盖这个方法
     * @return number
     */
    public function thirdPartDeposit($amount)
    {
        return $this->jdDeposit($amount);
    }
    
    /**
     * 赠品扣除
     * @param unknown $amount
     * @return number
     */
    public function appendDeposit($amount)
    {
        return 0;
    }
    
    /**
     * 即时返还 扣除
     */
    public function deposit(\stdClass $amount, $freight)
    {
        return 0;
    }
    
    
    /**
     * 其它返还 扣除
     */
    public function depositOther(\stdClass $amount, $freight)
    {
        return 0;
    }
    
    
    /**
     * 返还
     * 如果是导入的订单 快递费是需要计算的 
     * 10  18
     * 12
     * 18
     */
    public function returnDeposit($amount, $freight)
    {
        //商品金额- 商品扣除 -仓储扣除 -京东扣除-运费扣除
        return round($amount->sale - $this->goodsDeposit($amount->sale) - $this->entrepotDeposit($amount) - $this->jdDeposit($amount->sale) - $freight, 2);
    }
    
    /**
     * 返还
     * 如果是导入的订单 快递费是需要计算的
     * 10  18
     * 12
     * 18
     */
    public function returnJdDeposit($amount, $freight)
    {
        //商品金额- 商品扣除 -仓储扣除 -京东扣除-运费扣除
        return round($amount - $this->goodsDeposit($amount) - $this->entrepotDepositItem($amount) - $this->jdDeposit($amount) - $freight, 2);
    }
    
    /**
     * 即时返还
     * depositdetail用的获取商品的扣除
     */
    public function getSaleDeposit(\stdClass $amount, $freight)
    {
        return round($this->goodsDeposit($amount->sale)  + $this->entrepotDepositItem($amount->sale) + $this->thirdPartDeposit($amount->sale)+ $freight,2);
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
        return $this->getSaleDeposit($amount);
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