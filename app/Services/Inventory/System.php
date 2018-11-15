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
     * @param array|collection $products
     * @return number
     */
    public function entryUpdate($entrepot_id,  $products)
    {
        $affectedRows = 0;
        
//         DB::beginTransaction();
        try{
            foreach ($products as $product) {
                if ($this->model->hasOneBySkuSn($entrepot_id, $product->getSkuSn())) {
                    $affectedRows = $this->updates('set entrepot_count = entrepot_count + ? , saleable_count = saleable_count + ?, produce_in = produce_in + ?',
                        [ $product->getNum(), $product->getNum(),$product->getNum(),$entrepot_id, $product->getSkuSn() ]);
                    $this->updateIsSuccess($affectedRows);
                } else {
                    $re = $this->model->fill([
                        'entrepot_id'  => $entrepot_id,
                        'sku_sn'       => $product->getSkuSn(),
                        'goods_name'   => $product->getName(),
                        'entrepot_count' => $product->getNum(),
                        'saleable_count' => $product->getNum(),
                    ])->save();
                    
                    //模拟成功
                    if ($re) {
                        $affectedRows += 1;
                    } else {
                        $this->updateIsSuccess(0);
                    }
                  
                }    
            }
            $this->updateIsSuccess($affectedRows);
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
    public function outUpdate($entrepot_id,  $products)
    {
        $affectedRows = 0;
//         DB::beginTransaction();
        try{
            foreach ($products as $product) {
                $affectedRows = $this->updates('set entrepot_count = entrepot_count + ? , saleable_count = saleable_count + ?',
                    [ $product->getNum(), $product->getNum(), $entrepot_id, $product->getSkuSn() ]);
                $this->updateIsSuccess($affectedRows);
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
    public function saleLock($entrepot_id,  $products, $on = true)
    {
        $affectedRows = 0;
//         DB::beginTransaction();
        $countoper = $on ? '-' : '+';
        $lockoper = $on ? '+' : '-' ;
        try{
            foreach ($products as $product) {
                $affectedRows = $this->updates('set  saleable_count = saleable_count '.$countoper.' ? , sale_lock = sale_lock '.$lockoper.' ?',
                    [ $product->getNum(), $product->getNum(), $entrepot_id, $product->getSkuSn() ]);
                $this->updateIsSuccess($affectedRows);
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
    public function assignLock($entrepot_id,  $products, $on = true)
    {
        $affectedRows = 0;
//         DB::beginTransaction();
        $saleoper   = $on ? '-' : '+';
        $assignoper = $on ? '+' : '-' ;
        try{
            foreach ($products as $product) {
                $affectedRows = $this->updates('set  sale_lock = sale_lock '.$saleoper.' ? , assign_lock = assign_lock '.$assignoper.' ?',
                    [ $product->getNum(), $product->getNum(), $entrepot_id, $product->getSkuSn() ]);
                $this->updateIsSuccess($affectedRows);
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
    public function rxUpdate($entrepot_id,  $products)
    {
        $affectedRows = 0;
//         DB::beginTransaction();
        try{
            foreach ($products as $product) {
                $str=null;
                if ($product->isExchange()) {
                    $str = " , exchange_in = exchange_in + ? ";
                } else if($product->isReturn()) {
                    $str = " , return_in = return_in + ? ";
                } else {
                    $str = "";
                    throw new \Exception("退换货入库操作 商品退换类型错误 ");
                }
                $affectedRows = $this->updates('set entrepot_count = entrepot_count + ? , saleable_count = saleable_count + ? ' . $str,
                    [ $product->getNum(), $product->getNum(), $product->getNum(), $entrepot_id, $product->getSkuSn() ]);
                $this->updateIsSuccess($affectedRows);
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
    public function rxUpdateout($entrepot_id,  $products)
    {
        $affectedRows = 0;
//         DB::beginTransaction();
        try{
            foreach ($products as $product) {
                $affectedRows = $this->updates('set entrepot_count = entrepot_count - ? , saleable_count = saleable_count - ?',
                    [ $product->getNum(), $product->getNum(), $entrepot_id, $product->getSkuSn() ]);
                $this->updateIsSuccess($affectedRows);
            }
//             DB::commit();
        } catch (\Exception $e) {
//             DB::rollBack();
            throw $e;
        }
        
        return $affectedRows;
        
    }
    
    /**
     *  损坏出库
     */
    public function destroyUpdateOut($entrepot_id,  $products)
    {
        $affectedRows = 0;
        //         DB::beginTransaction();
        try{
            foreach ($products as $product) {
                $affectedRows = $this->updates('set entrepot_count = entrepot_count - ? , saleable_count = saleable_count - ?, destroy_count = destroy_count + ? ',
                    [ $product->getNum(), $product->getNum(),$product->getNum(),$entrepot_id, $product->getSkuSn() ]);
                $this->updateIsSuccess($affectedRows);
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
    public function stockCheck($entrepot_id , $products)
    {
        $affectedRows = 0;
        //         DB::beginTransaction();
        try{
            foreach ($products as $product) {
                $affectedRows += $this->updates('set entrepot_count = entrepot_count + ? , saleable_count = saleable_count + ?',
                    [ $product->getNum(), $product->getNum(),  $entrepot_id, $product->getSkuSn() ]);
            }
                $this->updateIsSuccess($affectedRows);
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
    public function exLock($entrepot_id,  $products, $on = true)
    {
        $affectedRows = 0;
        //         DB::beginTransaction();
        $countoper = $on ? '-' : '+';
        $lockoper = $on ? '+' : '-' ;
        try{
            foreach ($products as $product) {
                $affectedRows = $this->updates('set  saleable_count = saleable_count '.$countoper.' ? , exchange_lock = exchange_lock '.$lockoper.' ?',
                    [ $product->getNum(), $product->getNum(), $entrepot_id, $product->getSkuSn() ]);
                $this->updateIsSuccess($affectedRows);
            }
            //             DB::commit();
        } catch (\Exception $e) {
            //             DB::rollBack();
            throw $e;
        }
        
        return $affectedRows;
    }
    
    public function sending($entrepot_id,  $products, $on = true)
    {
        // send_ing
        $affectedRows = 0;
        $countoper = $on ? '-' : '+' ;
        $sendoper = $on ? '+' :'-';
        try{
            foreach ($products as $product) {
                if ($product->isResend()) {
                    $lockFiled = 'exchange_lock = exchange_lock '.$countoper.' ? ';
                } else {
                    $lockFiled = 'assign_lock = assign_lock '.$countoper.' ?';
                }
                $affectedRows += $this->updates('set entrepot_count = entrepot_count '.$countoper.' ? ,  '.$lockFiled.' , send_ing = send_ing '.$sendoper.' ?',
                    [ $product->getNum(), $product->getNum(), $product->getNum(), $entrepot_id, $product->getSkuSn() ]);
                $this->updateIsSuccess($affectedRows);
            }
        } catch (\Exception $e ) {
            throw $e;
        }
        return $affectedRows;
        
    }
    
    /**
     * 签收
     * @param unknown $entrepot_id
     * @param unknown $products
     */
    public function sign($entrepot_id, $products)
    {
        // send_ing
        $affectedRows = 0;
        try{
            foreach ($products as $product) {
                $affectedRows += $this->updates('set send_ing = send_ing - ? ,sale_count = sale_count + ? ',
                    [ $product->getNum(), $product->getNum(), $entrepot_id, $product->getSkuSn() ]);
            }
            $this->updateIsSuccess($affectedRows);
        } catch (\Exception $e ) {
            throw $e;
        }
        return $affectedRows;
    }
    
    /**
     * 
     */
    public function sample($entrepot_id, $products)
    {
        $affectedRows = 0;
        try{
            foreach ($products as $product) {
                $affectedRows = $this->updates('set entrepot_count = entrepot_count - ? ,  saleable_count = saleable_count - ? ',
                    [ $product->getNum(), $product->getNum(), $entrepot_id, $product->getSkuSn() ]);
                $this->updateIsSuccess($affectedRows);
            }
        } catch (\Exception $e ) {
            throw $e;
        }
        return $affectedRows;
    }
    
    
    /**
     * 套装 加 减
     * 只扣可售数量
     * @param unknown $entrepot_id
     * @param unknown $products
     * @throws Exception
     * @return number
     */
    public function combo($entrepot_id,  $products , $on = true)
    {
        $affectedRows = 0;
        $countoper = $on ? '+' : '-' ;
        try{
            foreach ($products as $product) {
                $affectedRows = $this->updates('set saleable_count = saleable_count '.$countoper.' ?',
                    [ $product->getNum(), $entrepot_id, $product->getSkuSn() ]);
                $this->updateIsSuccess($affectedRows);
            }
        } catch (\Exception $e ) {
            throw $e;
        }
        return $affectedRows;
        
    }
    
    public function comboGoods($entrepot_id,  $products , $on = true)
    {
        $affectedRows = 0;
        $countoper = $on ? '+' : '-';
        try{
            foreach ($products as $product) {
                $affectedRows= $this->updates('set entrepot_count= entrepot_count '.$countoper.' ?, saleable_count = saleable_count '.$countoper.' ?',
                    [ $product->getNum(), $product->getNum(), $entrepot_id, $product->getSkuSn() ]);
                $this->updateIsSuccess($affectedRows);
            }
            $this->updateIsSuccess($affectedRows);
        } catch (\Exception $e ) {
            throw $e;
        }
        return $affectedRows;
    }
    
    public function jdOrder($entrepot_id, $products, $on=true)
    {
        $affectedRows = 0;
        $countoper = $on ? '-' : '+';
        try{
            foreach ($products as $product) {
                $sql = 'SET entrepot_count=entrepot_count '.$countoper.' ?  , saleable_count = saleable_count '.$countoper. ' ? ';
//                 logger("[ds]",[$sql]);
                $affectedRows = DB::update('update '. self::TABLE.' '.$sql.' where entrepot_id = ? and sku_sn = ?', 
                    [$product->getNum(),$product->getNum(), $entrepot_id, $product->getSkuSn() ]);
                $this->updateIsSuccess($affectedRows);
            }
        } catch (\Exception $e ) {
            throw $e;
        }
        return true;
    }
    
    /**
     * 
     * @param unknown $affectedRows
     * @throws \Exception
     */
    private function updateIsSuccess($affectedRows)
    {
//         logger("[dg]", [$affectedRows]);
        if ($affectedRows == 0) {
            throw new \Exception('库存操作失败');
        }
    }
}