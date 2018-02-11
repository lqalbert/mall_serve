<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\Event' => [
            'App\Listeners\EventListener',
        ],
        
        'App\Events\AddEmployee' => [
            'App\Listeners\SyncEmployeeRoleListener',
        ],
    		
    	'App\Events\AddDepartment' => [
    		'App\Listeners\SetManagerDepartmentIdListener'	
    	],
    		
    	'App\Events\ChangeDepartmentManager' => [
    		'App\Listeners\SetManagerDepartmentIdListener'
    	],
    		
    	'App\Events\UpdateGroupCaptain' => [
    		'App\Listeners\UpdateUserGroupIdListener'
    	],
    		
    	'App\Events\SetCustomerUser' => [
    		'App\Listeners\SetCustomerUserListener'
    	]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
