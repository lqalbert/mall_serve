<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SetCustomerUser
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
	
    private $data = [];
    
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($cus_id, $type, $user_id, $group_id, $department_id)
    {
    	$this->data['cus_id'] = $cus_id;
    	$this->data['user_id'] = $user_id;
    	$this->data['type'] = empty($type) ? 0 : intval($type);
    	$this->data['group_id'] = $group_id;
    	$this->data['department_id'] = $department_id;
    	
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
    
    public function getData()
    {
    	return $this->data;
    }
}
