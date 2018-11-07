<?php
namespace App\Services\DepositOperation;

use App\Models\DepositDetail;

class DepositDetailService
{
    private $model = null;
    private $algorithm = null;
    private $amount = null;
    
    public function __construct(DepositDetail $model)
    {
        $this->model = $model;
    }
    
    public function setAlgorithm($algorithm)
    {
        $this->algorithm = $algorithm;
    }
    
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }
    
    public function setDetail($id, $freight)
    {
        $deposit  = $this->algorithm->goodsDeposit($this->amount->sale) 
                  + $this->algorithm->entrepotDepositItem($this->amount->sale) 
                  + $this->algorithm->thirdPartDeposit($this->amount->sale) 
                  + $this->algorithm->thirdPartDeposit($this->amount->sale)
                  + $freight;
        $detailModel = DepositDetail::create([
            'order_id' => $id,
            'type' => DepositDetail::TYPE_ONE,
            'amount' => $this->amount->sale,
            'deposit' => $deposit,
            'saler_point' => $this->algorithm->goodsDeposit($this->amount->sale),
            'entrepot_point' => $this->algorithm->entrepotDepositItem($this->amount->sale),
            'thirdpart_point' => $this->algorithm->thirdPartDeposit($this->amount->sale),
            'freight' => $freight,
            'return_deposit'=> '0.00'
        ]);
        
        return $detailModel;
    }
    
    public function setAppendDetail($id)
    {
        if ( empty(intval($this->amount->append * 100)) ) {
            return null;
        }
        $deposit  = $this->algorithm->appendDeposit($this->amount->append)
        + $this->algorithm->entrepotDepositItem($this->amount->append)
        + $this->algorithm->thirdPartDeposit($this->amount->append)
        + $this->algorithm->thirdPartDeposit($this->amount->append);
        $detailModel = DepositDetail::create([
            'order_id' => $id,
            'type' => DepositDetail::TYPE_TWO,
            'amount' => $this->amount->append,
            'deposit' => $deposit,
            'saler_point' => $this->algorithm->appendDeposit($this->amount->append),
            'entrepot_point' => $this->algorithm->entrepotDepositItem($this->amount->append),
            'thirdpart_point' => $this->algorithm->thirdPartDeposit($this->amount->append),
            'freight' => '0.00',
            'return_deposit'=> '0.00'
        ]);
        
        return $detailModel;
    }
    
    public function setReturnDeposit($id, $amount)
    {
        $model = $this->model->where('order_id', $id)->where('type', DepositDetail::TYPE_ONE)->first();
        if($model) {
            $model->return_deposit = $amount;
            if (!$model->save()) {
                throw new \Exception('扣返明细商品返还设置失败');
            }
        }
    }
    
    public function setAppendReturnDeposit($id, $amount)
    {
        $model = $this->model->where('order_id', $id)->where('type', DepositDetail::TYPE_TWO)->first();
        if($model) {
            $model->return_deposit = $amount;
            if (!$model->save()) {
                throw new \Exception('扣返明细赠品返还设置失败');
            }
        }
    }
    
    
}