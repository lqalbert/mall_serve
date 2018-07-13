<?php
namespace App\Services\Inventory;


use App\Models\InventorySystem;
use Illuminate\Support\Facades\DB;

class System 
{
    const TABLE = 'inventory_system';
    
    
    public function __construct()
    {
        
        $this->model = new InventorySystem();
    }
    
    private function updates($sql, $arg)
    {
        return DB::update('update '. self::TABLE.' '.$sql.' where entrepot_id = ? and sku_sn = ?', $arg);
    }
    
    
    /**
     * 入库
     * @param unknown $entrepot_id
     * @param array $products
     * @return number
     */
    public function entryUpdate($entrepot_id, array $products)
    {
        $affectedRows = 0;
        
//         DB::beginTransaction();
        try{
            foreach ($products as $product) {
                if ($this->model->hasOneBySkuSn($entrepot_id, $product->getSkuSn())) {
                    $affectedRows += $this->updates('set entrepot_count = entrepot_count + ? , saleable_count = saleable_count + ?, produce_in = produce_in + ?',
                        [ $product->getNum(), $product->getNum(),$product->getNum(),$entrepot_id, $product->getSkuSn() ]);
                } else {
                    $this->model->fill([
                        'entrepot_id'  => $entrepot_id,
                        'sku_sn'       => $product->getSkuSn(),
                        'goods_name'   => $product->getName(),
                        'entrepot_count' => $product->getNum(),
                        'saleable_count' => $product->getNum(),
                    ])->save();
                    
                }
                
                
            }
//             DB::commit();
        } catch (\Exception $e) {
//             DB::rollBack();
            logger('[sql]', [$e->getMessage()]);
            throw $e;
        }
        
        return $affectedRows;
    }
    
    
    /**
     * 出库 生产出库/损坏出库
     */
    public function outUpdate($entrepot_id, array $products)
    {
        $affectedRows = 0;
//         DB::beginTransaction();
        try{
            foreach ($products as $product) {
                $affectedRows += $this->updates('set entrepot_count = entrepot_count + ? , saleable_count = saleable_count + ?',
                    [ $product->getNum(), $product->getNum(), $entrepot_id, $product->getSkuSn() ]);
            }
//             DB::commit();
        } catch (\Exception $e) {
//             DB::rollBack();
            throw $e;
        }
        
        return $affectedRows;
    }
    
    /**
     * 销售锁定/解锁
     * 
     */
    public function saleLock($entrepot_id, array $products, $on = true)
    {
        $affectedRows = 0;
//         DB::beginTransaction();
        $countoper = $on ? '-' : '+';
        $lockoper = $on ? '+' : '-' ;
        try{
            foreach ($products as $product) {
                $affectedRows += $this->updates('set  saleable_count = saleable_count '.$countoper.' ? , sale_lock = sale_lock '.$lockoper.' ?',
                    [ $product->getNum(), $product->getNum(), $entrepot_id, $product->getSkuSn() ]);
            }
//             DB::commit();
        } catch (\Exception $e) {
//             DB::rollBack();
            throw $e;
        }
        
        return $affectedRows;
    }
    
    
    /**
     * 发货锁定/解锁 
     * 解锁把发数量返回给销售锁定
     * 
     * @param unknown $entrepot_id
     * @param array $products
     * @param string $on
     * @return number
     */
    public function assignLock($entrepot_id, array $products, $on = true)
    {
        $affectedRows = 0;
//         DB::beginTransaction();
        $saleoper   = $on ? '-' : '+';
        $assignoper = $on ? '+' : '-' ;
        try{
            foreach ($products as $product) {
                $affectedRows += $this->updates('set  sale_lock = sale_lock '.$oper.' ? , assign_lock = assign_lock '.$oper.' ?',
                    [ $product->getNum(), $product->getNum(), $entrepot_id, $product->getSkuSn() ]);
            }
//             DB::commit();
        } catch (\Exception $e) {
//             DB::rollBack();
            throw $e;
        }
        
        return $affectedRows;
        
    }
    
    
    /**
     * 退换货入库
     */
    public function rxUpdate($entrepot_id, array $products)
    {
        $affectedRows = 0;
//         DB::beginTransaction();
        try{
            foreach ($products as $product) {
                $affectedRows += $this->updates('set entrepot_count = entrepot_count + ? , saleable_count = saleable_count + ?',
                    [ $product->getNum(), $product->getNum(), $entrepot_id, $product->getSkuSn() ]);
            }
//             DB::commit();
        } catch (\Exception $e) {
//             DB::rollBack();
            throw $e;
        }
        
        return $affectedRows;
    }
    
    /**
     * 退换货出库 先暂时这么写　以后可能会改
     */
    public function rxUpdateout($entrepot_id, array $products)
    {
        $affectedRows = 0;
//         DB::beginTransaction();
        try{
            foreach ($products as $product) {
                $affectedRows += $this->updates('set entrepot_count = entrepot_count - ? , saleable_count = saleable_count - ?',
                    [ $product->getNum(), $product->getNum(), $entrepot_id, $product->getSkuSn() ]);
            }
//             DB::commit();
        } catch (\Exception $e) {
//             DB::rollBack();
            throw $e;
        }
        
        return $affectedRows;
        
    }
    
    
    /**
     * 盘点
     * @param unknown $entrepot_id
     * @param array $products
     */
    public function stockCheck($entrepot_id ,array $products)
    {
        $affectedRows = 0;
        //         DB::beginTransaction();
        try{
            foreach ($products as $product) {
                $affectedRows += $this->updates('set entrepot_count = entrepot_count + ? , saleable_count = saleable_count + ?',
                    [ $product->getNum(), $product->getNum(), $entrepot_id, $product->getSkuSn() ]);
            }
            //             DB::commit();
        } catch (\Exception $e) {
            //             DB::rollBack();
            throw $e;
        }
        
        return $affectedRows;
    }
    
    /**
     * 换货锁定/解锁
     *
     */
    public function exLock($entrepot_id, array $products, $on = true)
    {
        $affectedRows = 0;
        //         DB::beginTransaction();
        $countoper = $on ? '-' : '+';
        $lockoper = $on ? '+' : '-' ;
        try{
            foreach ($products as $product) {
                $affectedRows += $this->updates('set  saleable_count = saleable_count '.$countoper.' ? , exchange_lock = exchange_lock '.$lockoper.' ?',
                    [ $product->getNum(), $product->getNum(), $entrepot_id, $product->getSkuSn() ]);
            }
            //             DB::commit();
        } catch (\Exception $e) {
            //             DB::rollBack();
            throw $e;
        }
        
        return $affectedRows;
    }
}