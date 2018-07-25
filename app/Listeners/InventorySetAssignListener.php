<?php

namespace App\Listeners;

use App\Events\OrderPass;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Services\Inventory\InventoryService;

class InventorySetAssignListener
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
     * @param  OrderPass  $event
     * @return void
     */
    public function handle(OrderPass $event)
    {
        $order = $event->getOrder();
        $this->inventorySys->assignLock($order->entrepot, $event->getGoods(), $event->getUser());
    }
}
