<?php
/**
 *  库存系统 处理库存
 */
namespace App\Listeners;

use App\Events\AddOrder;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AddOrderListener
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
     * @param  AddOrder  $event
     * @return void
     */
    public function handle(AddOrder $event)
    {
        //
    }
}
