<?php

namespace App\Listeners;

use App\Events\OrderPass;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Assign;
use App\Models\OrderGoods;
use App\Models\OrderAddress;

class CreateAssignListener
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
     * 要改成一个商品一个快递号
     *
     * @param  OrderPass  $event
     * 
     * @throws 
     * 
     * @return void
     */
    public function handle(OrderPass $event)
    {
        $order = $event->getOrder();
        $data = [
            'entrepot_id'=> $order->entrepot_id,
            'order_id'   => $order->id,
            'address_id' => $order->address_id,
        ];
        
        $express = $order->isSetExpress();
        if ($express) {
            $data['set_express'] = 1;
            $data['set_express_name'] = $express;
        }

        $model = Assign::create($data);
        if ($model== false) {
            throw new \Exception('发货单创建失败');
        }

        $goods = $order->getGoods();
        $goods->each(function ($item, $key) use($model){
               $item->assign_id = $model->id;
               $item->save();
        });
    }
}
