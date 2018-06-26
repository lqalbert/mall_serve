<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Models\StockCheck;

class StockChecked
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    
    private $model = null;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(StockCheck $model)
    {
        $this->model = $model;
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

    public function getModel()
    {
        return $this->model;
    }
}
