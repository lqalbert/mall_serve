<?php

namespace App\Listeners;

use App\Events\AddOrderOperationLog;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AddOrderOperationLogListener
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
     *
     * @param  AddOrderOperationLog  $event
     * @return void
     */
    public function handle(AddOrderOperationLog $event)
    {
        //
    }
}
