<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\models\OrderBasic;
use App\Models\User;

class AddDepositOperationLog
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $orderModel;
    public $action;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user,OrderBasic $orderModel,$action='')
    {
        $this->user = $user;
        $this->orderModel = $orderModel;
        $this->action = $action;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    // public function broadcastOn()
    // {
    //     return new PrivateChannel('channel-name');
    // }
}
