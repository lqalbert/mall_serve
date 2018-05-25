<?php
/**
 * menugs 里面的索引
 */
return [
    'administrator' => [
        '*'
    ],
    'super-manager' => [
        '*'
    ],
    'sale-manager' => [
        'GoodsDetails',
        'Group',
        'Employee',
        'Customer',
        'OrderList',
        'BuyOrders',
        'Refund',
        'Workbench',
        'SysNotice',
        'Contacts',
        'Website'
    ],
    'human-resources' => [
      
        'Employee',
       
        
        'Workbench',
        'SysNotice',
        'Contacts',
        'Website'
    ],
    'sale-captain' => [
        'GoodsDetails',
        'Employee',
        'Customer',
        'OrderList',
        'Workbench',
        'SysNotice',
        'Contacts',
        'Website'
    ],
    'sale-staff' => [
        'GoodsDetails',
        'Customer',
        'OrderList',
        'Workbench',
        'SysNotice',
        'Contacts',
        'Website'
    ],
    // 隐藏的角色
    'group-member' => [],
    'department-manager' => [],
    'group-captain' => [],
    'sale-department-member' => []
];