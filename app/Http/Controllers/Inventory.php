<?php
namespace App\Http\Controllers;

class Inventory 
{
    /**
     * 添加订单逻辑
     * @todo 
     *  1、 生成锁定记录 表结构参考 库存明细下面的销售锁定
     *  2、 库存表（还没建）  更新对应的 可售数量和锁定数量 注意 要用事务
     *  3、 扣保证金 （并生成记录）
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
}