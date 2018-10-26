<?php

namespace App\Listeners;

use App\Events\OrderPass;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\DepositRecord;
use App\Events\AddDepositOperationLog;
use App\Services\DepositOperation\DepositAppLogicService;

class DepositDecrementListener
{
    
    private $service = null;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(DepositAppLogicService $service)
    {
        $this->service = $service;
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
        $this->service->depositAtCheck($order);
//         $operator = $event->getUser();
//         //部门
//         $department   =  $order->department ;
        
//         $money = $order->getDeposit();
//         $department->subDeposit($money);
//         if ($department->isNegative()) {
//             throw new \Exception('保证金不足');
//         }
//         $department->save();

//         //扣钱成功 记录一下
//         DepositRecord::create([
//             'user_id' => $operator->id, //操作员工
//             'target_id' => $order->user->id,
//             'event_type' => DepositRecord::APP_EVENT_ORDER_PASS,
//             'money' => -$money,
//             'brief' => '订单号：'.$order->order_sn
//         ]);
        
//         //添加保证金日志
//         event(new AddDepositOperationLog($operator,$order,'check'));
        
    }
}
