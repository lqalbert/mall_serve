<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Console\Commands\Deposit2;
use App\Models\DepositSet2;

class SyncDiscount
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    
    private $model = null;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(DepositSet2 $model)
    {
        $this->model = $model;
    }

    public function getModel()
    {
        return $this->model;
    }
   
}
