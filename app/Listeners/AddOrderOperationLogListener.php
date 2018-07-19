<?php

namespace App\Listeners;

use App\Events\AddOrderOperationLog;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\OrderOperationLog;

class AddOrderOperationLogListener
{
    public $operationModel;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(OrderOperationLog $operation)
    {
        $this->operationModel = $operation;
    }

    /**
     * Handle the event.
     *
     * @param  AddOrderOperationLog  $event
     * @return void
     */
    public function handle(AddOrderOperationLog $event)
    {
        $dataLog = $event->dataLog;
        $this->operationModel->operator_id = $event->user->id;
        $this->operationModel->operator = $event->user->realname;
        $this->operationModel->order_id = $dataLog['order_id'];
        $this->operationModel->action = $dataLog['action'];
        $this->operationModel->remark = $dataLog['remark'];
        $this->operationModel->save();
    }
}
