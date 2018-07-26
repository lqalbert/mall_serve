<?php

namespace App\Listeners;

use App\Events\AddAssignOperationLog;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\AssignOperationLog;

class AddAssignOperationLogListener
{
    public $operationModel;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(AssignOperationLog $operation)
    {
        $this->operationModel = $operation;
    }

    /**
     * Handle the event.
     *
     * @param  AddAssignOperationLog  $event
     * @return void
     */
    public function handle(AddAssignOperationLog $event)
    {
        $dataLog = $event->dataLog;
        $this->operationModel->operator_id = $event->user->id;
        $this->operationModel->operator = $event->user->realname;
        $this->operationModel->assign_id = $dataLog['assign_id'];
        $this->operationModel->action = $dataLog['action'];
        $this->operationModel->remark = $dataLog['remark'];
        $this->operationModel->save();
    }
}
