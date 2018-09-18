<?php
namespace App\Services\Inventory;

use App\Models\InventoryDetail;
use App\Models\DistributionCenter;
use App\Models\User;

class Detail
{
    private $model = null;
    
    public function __construct(InventoryDetail $detail) 
    {
        $this->model = $detail;
    }
    
    
    private function setAttributes($entrepot, $product, $user, $dan=null)
    {
        return [
            'entrepot_id'=>$entrepot->id,
            'entrepot_name' => $entrepot->name,
            'sku_sn' => $product->getSkuSn(),
            'goods_name' => $product->getName(),
            
            'user_id'   => $user->id,
            'user_name' => $user->realname,
            
//             'produce_in' => $product->getNum(),
            'dan_sn' => $dan
        ];
    }
    
    private function save($entrepot, $products, $user, $arg, $dan=null)
    {
        foreach ($products as $product) {
            $model = $this->model->newInstance(
                array_merge($this->setAttributes($entrepot, $product, $user, $dan), [ $arg=> $product->getNum()])
            );
            $model->save();
        }
    }
    
    /**
     * 入库
     * @param DistributionCenter $entrepot
     * @param unknown $products
     * @param User $user
     */
    public function entryUpdate(DistributionCenter $entrepot, $products, User $user)
    {
        $this->save($entrepot, $products, $user, 'produce_in');
    }
    
    /**
     * 销售锁定
     * @param DistributionCenter $entrepot
     * @param unknown $products
     * @param User $user
     */
    public function saleLock(DistributionCenter $entrepot, $products, User $user)
    {
        $this->save($entrepot, $products, $user, 'sale_lock');
    }
    
    /**
     * 发货锁定
     * @param DistributionCenter $entrepot
     * @param unknown $products
     * @param User $user
     */
    public function assignLock(DistributionCenter $entrepot, $products, User $user)
    {
        $this->save($entrepot, $products, $user, 'assign_lock');
    }
    
    /**
     * 发货解锁
     * @param DistributionCenter $entrepot
     * @param unknown $products
     * @param User $user
     */
    public function assignUnLock(DistributionCenter $entrepot, $products, User $user)
    {
        $this->save($entrepot, $products, $user, 'assign_unlock');
    }
    
    
    /**
     * 换货锁定
     * @param DistributionCenter $entrepot
     * @param unknown $products
     * @param User $user
     */
    public function exchangeLock(DistributionCenter $entrepot, $products, User $user, $dan)
    {
        $this->save($entrepot, $products, $user, 'exchange_lock', $dan);
    }
    
    
    /**
     * 盘点
     */
    public function stock(DistributionCenter $entrepot, $products, User $user, $dan)
    {
        $in = [];
        $out = [];
        foreach ($products as $product){
            if ($product->getNum() >= 0) {
                $in[] = $product;
            } else {
                $out[] = $product;
            }
        }
//         logger("[da-in]",$in);
        if (!empty($in)) {
            $this->save($entrepot, $in, $user, 'stock_in', $dan);
        }
//         logger("[da-out]",$out);
        if (!empty($out)) {
            $this->save($entrepot, $out, $user, 'stock_out', $dan);
        }
        
    }
    
    
    /**
     * 退换货入库
     */
    public function rxUpdate(DistributionCenter $entrepot, $products, User $user, $dan)
    {
        $returnProducts = [];
        $exchangeProducts = [];
        
        foreach ($products as $product) {
            if ($product->isExchange()) {
                $exchangeProducts[] = $product;
            } else if ($product->isReturn()) {
                $returnProducts[] = $product;
            } else {
                throw new \Exception("退换货入库明细 商品退换类型错误");
            }
        }
        
        if (count($returnProducts) != 0) {
            $this->save($entrepot, $returnProducts, $user, 'return_in', $dan);
        }
        
        if (count($exchangeProducts) != 0) {
            $this->save($entrepot, $exchangeProducts, $user, 'exchange_in', $dan);
        }
    }
    
    
    /**
     * 发货在途
     */
    public function sending(DistributionCenter $entrepot, $products, User $user, $dan)
    {
        $this->save($entrepot, $products, $user, 'send_ing', $dan);
    }
    
    public function sample(DistributionCenter $entrepot, $products, User $user)
    {
        $this->save($entrepot, $products, $user, 'sample');
    }
    
    
    
    
}