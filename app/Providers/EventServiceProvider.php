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
    	],
        
        'App\Events\AddOrder' => [
            'App\Listeners\AddOrderListener',
            'App\Listeners\ChangeCustomerToVListener'
        ],
        
        'App\Events\OrderCreating' => [
            'App\Listeners\OrderCreatingListener'
        ],
        'App\Events\OrderCancel' => [
            'App\Listeners\OrderCancelListener',
        ],
        
        'App\Events\ProduceEntryCreating' => [
            'App\Listeners\ProduceEntryCreatingListener'
        ],
        
        'App\Events\ProduceEntried' => [
            'App\Listeners\ProduceEntriedListener'
        ],
        //订单通过审核 第一个事件可能会返回false（钱不够了） 来阻止后面的执行
        //所以在处理这个事件时需要另外的 事务处理 
        'App\Events\OrderPass' => [
            'App\Listeners\OrderPassCheckedListener',
            'App\Listeners\DepositDecrementListener', //扣保证金
            'App\Listeners\InventorySetAssignListener', //通知库存 进行对应的更新
            'App\Listeners\CreateAssignListener',//生成配货单 生成发货锁定
        ],
        
        'App\Events\OrderUnPass' => [],
        
        'App\Events\AssignCreating' => [
            //生成assign_sn
            'App\Listeners\AssignCreatingListener'
        ],
        
        //生成发货记录 不用了 配货单自动就有了
        //库存表 更新对应的字段
        // @todo 修改订单状态 为 已发货
        'App\Events\DeliverGoods' => [
            'App\Listeners\InventoryAssignedListener'
        ],
           
        //签名
        // @todo 修改订单状态为 已签收
        'App\Events\Signatured' => [
            'App\Listeners\InventorySignaturedListener'
        ],
        
        //售后
        'App\Events\AddAfterSale' => [
            'App\Listeners\ChangeOrderAfterSaleListener'
        ],
        
        'App\Events\ContactConflict' => [
            'App\Listeners\ContactconflictListener'
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
