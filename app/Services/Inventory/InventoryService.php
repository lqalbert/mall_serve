<?php
namespace App\Services\Inventory;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class InventoryService
{
    private $inventory = null;
    private $log = null;
    
    public function __construct(System $system, Detail $detail)
    {
        $this->inventory = $system;
        $this->log = $detail;
    }
    
    
    /**
     * 生产入库
     * @param unknown $entrepot
     * @param unknown $products
     * @param unknown $user
     * @throws Exception
     */
    public function entryUpdate($entrepot, $products, $user)
    {
        DB::beginTransaction();
        try {
//             logger('[debug]', $entrepot->toArray());
            $this->inventory->entryUpdate($entrepot->id, $products);
            $this->log->entryUpdate($entrepot, $products, $user);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception('库存更新失败');
        }
    }
    
    /**
     * 销售锁定
     * @param unknown $entrepot
     * @param array $products
     * @param unknown $user
     * @throws Exception
     */
    public function saleLock($entrepot, $products, $user)
    {
        DB::beginTransaction();
        try {
            $this->inventory->saleLock($entrepot->id, $products);
            $this->log->saleLock($entrepot, $products, $user);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
//             throw $e;
            throw new \Exception('库存更新失败');
        }
    }
    
    /**
     * 销售解锁
     * @param unknown $entrepot
     * @param unknown $products
     * @param unknown $user
     * @throws Exception
     */
    public function saleUnLock($entrepot, $products, $user)
    {
        DB::beginTransaction();
        try {
            $this->inventory->saleLock($entrepot->id, $products, false);
//             $this->log->saleLock($entrepot, $products, $user);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception('库存更新失败');
        }
    }
    
    /**
     * 发货锁定 解锁
     * @param unknown $entrepot
     * @param unknown $products
     * @param unknown $user
     * @throws Exception
     */
    public function assignLock($entrepot, $products, $user, $on=true)
    {
        DB::beginTransaction();
        try {
            $this->inventory->assignLock($entrepot->id, $products, $on);
            if ($on) {
                $this->log->assignLock($entrepot, $products, $user);
            } else {
                $this->log->assignUnLock($entrepot, $products, $user);
            }
            
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception('库存更新失败');
        }
    }
    
    /**
     * 发货在途
     * @param unknown $entrepot
     * @param unknown $products
     * @param unknown $user
     */
    public function sending($entrepot, $products, $user, $dan, $on=true)
    {
        DB::beginTransaction();
        try {
            $this->inventory->sending($entrepot->id, $products, $on);
            if ($on) {
                $this->log->sending($entrepot, $products, $user, $dan);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception('库存更新失败');
        }
    }
    
    /**
     * 退换货入库
     * @param unknown $entrepot
     * @param unknown $products
     * @param unknown $user
     * @throws Exception
     */
    public function rxUpdate($entrepot, Collection $products, $user, $dan=null)
    {
        DB::beginTransaction();
        try {
            $this->inventory->rxUpdate($entrepot->id, $products);
            $this->log->rxUpdate($entrepot, $products, $user, $dan);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception('库存更新失败');
        }
    }
    
    
    /**
     * 退货出库
     * @param unknown $entrepot
     * @param unknown $products
     * @param unknown $user
     * @throws Exception
     */
    public function rxUpdateout($entrepot, $products, $user)
    {
        DB::beginTransaction();
        try {
            $this->inventory->rxUpdateout($entrepot->id, $products);
            //             $this->log->assignLock($entrepot, $products, $user);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception('库存更新失败');
        }
    }
    
    /**
     * 损坏出库
     */
    public function destroyUpdateOut($entrepot, $products, $user)
    {
        DB::beginTransaction();
        try {
            $this->inventory->destroyUpdateOut($entrepot->id, $products);
            $this->log->destroyNum($entrepot, $products, $user);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception('库存更新失败');
        }
    }
    
    
    /**
     * 盘点
     */
    public function stockCheck($entrepot, $products, $user, $dan)
    {
        DB::beginTransaction();
        try {
            $this->inventory->stockCheck($entrepot->id, $products);
            $this->log->stock($entrepot, $products, $user, $dan);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception('库存更新失败');
        }
    }
    
    /**
     * 换货锁定
     * @param unknown $entrepot
     * @param unknown $products
     * @param unknown $user
     * @throws Exception
     */
    public function exLock($entrepot, $products, $user, $dan)
    {
        DB::beginTransaction();
        try {
            $this->inventory->exLock($entrepot->id, $products);
            
            $this->log->exchangeLock($entrepot, $products, $user, $dan);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception('库存更新失败');
        }
    }
    
    /**
     * 签收
     * @param unknown $entrepot
     * @param unknown $products
     * @param unknown $user
     * @param unknown $dan
     */
    public function sign($entrepot, $products, $user, $dan)
    {
        DB::beginTransaction();
        try {
            $this->inventory->sign($entrepot->id, $products);
//             $this->log->exchangeLock($entrepot, $products, $user);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception('库存更新失败');
        }
    }
    
    public function sample($entrepot, $products, $user)
    {
        DB::beginTransaction();
        try {
            $this->inventory->sample($entrepot->id, $products);
            $this->log->sample($entrepot, $products, $user);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception('库存更新失败');
        }
    }
    
    /**
     * 套装 加 减 感觉就是入库和出库
     */
    public function combo($entrepot, $products, $user, $on)
    {
        DB::beginTransaction();
        try {
            if ($on) {
                //入库有日志
                $this->entryUpdate($entrepot, $products, $user);
            } else {
                $this->inventory->combo($entrepot->id, $products, false);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception('库存更新失败');
        }
    }
    
    /**
     * 套装对应的商品 加 减
     */
    public function comboGoods($entrepot, $products, $user, $on)
    {
        DB::beginTransaction();
        try {
            $this->inventory->comboGoods($entrepot->id, $products,$on);
            //             $this->log->sample($entrepot, $products, $user, $on);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception('库存更新失败');
        }
    }
    
    
}