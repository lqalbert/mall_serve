<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Models\OrderBasic;
use App\Models\User;
use App\Contracts\OrderGoodsContract;

class OrderPass implements OrderGoodsContract
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    
    private $order = null;
    /**
     * 当前操作的用户
     * @var unknown
     */
    private $user = null;
    
    
    private $goods= null;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(OrderBasic $order, User $user, $goods=null)
    {
        $this->order = $order;
        $this->user  = $user; 
        if ($goods) {
            $this->goods = $goods;
        } else {
            $this->goods = $order->goods;
        }
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
//     public function broadcastOn()
//     {
//         return new PrivateChannel('channel-name');
//     }

    public function getOrder()
    {
        return $this->order;
    }
    
    public function getUser()
    {
        return $this->user;
    }
    
    public function getGoods(){
        return $this->goods;
    }
}
