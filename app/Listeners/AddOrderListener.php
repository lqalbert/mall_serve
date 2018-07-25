<?php
/**
 *  库存系统 处理库存
 */
namespace App\Listeners;

use App\Events\AddOrder;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Services\Inventory\InventoryService;


class AddOrderListener
{
    private $inventorySys = null;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(InventoryService $inventory)
    {
        $this->inventorySys = $inventory;
    }

    /**
     * Handle the event.
     *
     * @param  AddOrder  $event
     * @return void
     */
    public function handle(AddOrder $event)
    {
        $order = $event->getOrder();
        $this->inventorySys->saleLock($order->entrepot, $order->goods, $order->user);
        
    }
}
