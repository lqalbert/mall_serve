<?php

namespace App\Listeners;

use App\Events\OrderCreating;
use App\Alg\Sn;
use App\models\OrderBasic;

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
    public function handle(OrderCreating $event)
    {
        $order = $event->getOrder();
        if (empty($order->entrepot_id)) {
            return false;
        }
        $order->order_sn = Sn::getOrderSn($order->entrepot->eng_name, $order->id);
        $order->save();
        return true;
    }
}
