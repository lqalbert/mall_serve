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
     * 换货锁定
     * @param DistributionCenter $entrepot
     * @param unknown $products
     * @param User $user
     */
    public function exchangeLock(DistributionCenter $entrepot, $products, User $user)
    {
        $this->save($entrepot, $products, $user, 'exchange_lock');
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
                $out = $product;
            }
        }
        if (!empty($in)) {
            $this->save($entrepot, $in, $user, 'stock_in', $dan);
        }
        
        if (!empty($out)) {
            $this->save($entrepot, $out, $user, 'stock_out', $dan);
        }
        
    }
    
    
    
    
}