<?php

namespace App\Listeners;

use App\Events\OrderCreating;
use App\Alg\Sn;
use App\models\OrderBasic;
use App\Events\OrderCreated;

class OrderCreatingListener
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
     * @param  OrderCreating  $event
     * @return void
     */
    public function handle(OrderCreated $event)
    {
        $order = $event->getOrder();
        if (empty($order->entrepot_id)) {
            return false;
        }
        if (!$order->order_sn) {
            $order->order_sn = Sn::getOrderSn($order->entrepot->eng_name, $order->id);
            $order->save();
        }
        return true;
    }
}
