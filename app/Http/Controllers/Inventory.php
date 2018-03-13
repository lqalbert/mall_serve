<?php
namespace App\Http\Controllers;

use App\Models\InventorySystem;
use Illuminate\Support\Facades\DB;

/**
 * 库存
 * @author hyf
 *
 */

class Inventory 
{
    
    protected $model = null;
    
    public function __construct()
    {
        $this->model = new InventorySystem();
    }
    /**
     * 添加订单逻辑
     * @todo 
     *  1、 生成锁定记录 表结构参考 库存明细下面的销售锁定
     *  2、 库存表（还没建）  更新对应的 可售数量和锁定数量 注意 要用事务
     *  //
     * 
     * 
     */
    public function AddOrder()
    {
        
    }
    
    /**
     * 取消订单逻辑
     * @todo 库存表 更新对应的 可售数量和锁定数量 注意 要用事务
     */
    public function cancelOrder()
    {
        
    }
    
    /**
     * 订单发货（通知仓库配货发货）
     * @todo 
     *  1、生成发货单
     *  2、库存表 更新对应的 销售锁定 和 发货锁定
     *  3、 扣保证金 （并生成记录）
     */
    public function setOrderAssign()
    {
        
    }
    
    /**
     * 发货完成
     * @todo 
     *  1、生成发货记录
     *  2、库存表 更新对应的 发货锁定 和  仓库数量 、发货在途
     */
    public function orderAssigned()
    {
        
    }
    
    /**
     * 签收 完成
     * @todo
     *  1、生成签收记录
     *  2、库存表 更新对应的 发货在途 和  签收数量
     */
    public function orderAssigned()
    {
        
    }
    
    /**
     * 生产入库
     * @todo 
     * 1、更新库存表
     * 
     * @param int $entrepot_id 仓库ID
     * @param array $products  商品数组
     */
    public function produceEntry($entrepot_id, $products)
    {
//        先判断库存有没有 
//         把没有的 挑出来 单独处理
//        有的就 直接调用 entrysUpdate
        
        $sku_sns = array_column($products, 'sku_sn');
        
        $checked_sku_sns = $this->model->hasSkuSns($entrepot_id, $sku_sns);
        $not_in_entrepot_products = array_map(function($value) use($checked_sku_sns){
            if (in_array($value['sku_sn'], $checked_sku_sns)  ) {
                return $value;
            }
        }, $products);
        
        DB::beginTransaction();
        try {
            //没有的 要insert
            if (!empty($not_in_entrepot_products)) {
                $inserts = [];
                foreach ($not_in_entrepot_products as $value) {
                    $inserts[] = [
                        'entrepot_id'=>$entrepot_id ,
                        'sku_sn' => $value['sku_sn'],
                        'goods_name' => $value['goods_name'],
                        'entrepot_count' => $value['num'],
                        'saleable_count' => $value['num']
                    ];
                };
                $this->model->insert($inserts);
            }
            //有的要 更新
            $this->model->entrysUpdate($entrepot_id);
        } catch (Exception $e) {
            DB::rollback();
        }
        
        DB::commit();  
    }
    
}