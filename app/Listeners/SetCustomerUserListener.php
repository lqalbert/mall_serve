<?php

namespace App\Listeners;

use App\Events\SetCustomerUser;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\CustomerUser;

class SetCustomerUserListener
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
     * @param  SetCustomerUser  $event
     * @return void
     */
    public function handle(SetCustomerUser $event)
    {
        $data = $event->getData();
        if ($data['type'] != CustomerUser::ADD) {
        	//软删除以前的;
        	CustomerUser::destroy($data['cus_id']);
        	//如果以后有其它字段可以 复制给data 以达到继承的目的
        }
        
        CustomerUser::create($data);
    }
}
