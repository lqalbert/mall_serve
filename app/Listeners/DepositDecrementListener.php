<?php

namespace App\Listeners;

use App\Events\OrderPass;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\DepositRecord;

class DepositDecrementListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     * 扣保证金 
     * @todo 在order_basic 表里用一个字段标识一下扣过保证金
     *
     * @param  OrderPass  $event
     * @return void
     */
    public function handle(OrderPass $event)
    {
        $order = $event->getOrder();
        $operator = $event->getUser();
        //部门
        $department   =  $order->department ;
     
        $department->subDeposit($order->order_pay_money);
        $department->save();

        //扣钱成功 记录一下
        DepositRecord::create([
            'user_id' => $operator->id, //操作员工
            'target_id' => $order->user->id,
            'event_type' => DepositRecord::APP_EVENT_ORDER_PASS,
            'money' => -$order->discounted_goods_money,
            'brief' => '订单号：'.$order->order_sn
        ]);
    }
}
