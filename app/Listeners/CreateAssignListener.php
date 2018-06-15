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
        logger("[debug]", ['not here']);
        $data = [
            'entrepot_id'=> $order->entrepot_id,
            'order_id'   => $order->id,
            'address_id' => $order->address->id,
        ];
        
        if ($order->isSetExpress()) {
            $data['set_express'] = 1;
            $data['express_id'] = $order->express_id;
            $data['express_name'] = $order->express_name;
        }
        logger("[debug]", ['not here2']);
        $model = Assign::create($data);
        if ($model== false) {
            throw new \Exception('发货单创建失败');
        }
        logger("[debug]", ['not here3']);
        $goods = $order->getGoods();
        $goods->each(function ($item, $key) use($model){
               $item->assign_id = $model->id;
               $item->save();
        });
        
        //更新 order_goods 表 assign_lock_at 字段为当前时间
//         $affectRows = OrderGoods::where('order_id', $order->id)->update(['assign_lock_at'=> Date('Y-m-d H:i:s')]);
//         if ($affectRows == 0 ) {
//             throw new \Exception('更新 assign_lock_at 失败');
//         }
    }
}
