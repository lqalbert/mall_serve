<?php

namespace App\Listeners;

use App\Events\AddDepositOperationLog;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\DepositOperationLog;

class AddDepositOperationLogListener
{
    public $operationModel;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(DepositOperationLog $operation)
    {
        $this->operationModel = $operation;
    }

    /**
     * Handle the event.
     *
     * @param  AddDepositOperationLog  $event
     * @return void
     */
    public function handle(AddDepositOperationLog $event)
    {
        $orderModel = $event->orderModel;
        $order_sn = $orderModel->order_sn;
        $dep = $orderModel->department->name;
        $money = $orderModel->getDeposit();

        $this->operationModel->operator_id = $event->user->id;
        $this->operationModel->operator = $event->user->realname;
        $this->operationModel->order_id = $orderModel->id;
        $this->operationModel->action = $event->action;
        
        switch ($event->action) {
            // 订单审核之后 才扣保证金， 审核之后不能取消
//             case 'cancel':
//                 $this->operationModel->remark = "订单".$order_sn."，部门".$dep.'保证金+'.$money;
//                 break;
            case 'check':
                $this->operationModel->remark = "订单".$order_sn."，部门".$dep.'保证金-'.$money;
                break;
            default:
                # code...
                break;
        }

        if (!$this->operationModel->save()) {
            throw new \Exception('订单保证金日志记录失败');
        }
    }
}
