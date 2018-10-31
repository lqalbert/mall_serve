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
        'Website',
        'SalesPerformance',
        'SalesQuantization',
        'http://ws.pulata.com.cn:8888/login'
//         'EarnestMoney'
    ],
    'human-resources' => [
      
        'Employee',
       
        
        'Workbench',
//         'SysNotice',
        'Contacts',
        'Website',
        'http://ws.pulata.com.cn:8888/login'
    ],
    'sale-captain' => [
        'GoodsDetails',
//         'Employee',
        'Customer',
        'OrderList',
        'Workbench',
//         'SysNotice',
        'Contacts',
        'Website',
        'SalesPerformance',
        'SalesQuantization',
        'http://ws.pulata.com.cn:8888/login'
    ],
    'sale-staff' => [
        'GoodsDetails',
        'Customer',
        'OrderList',
        'Workbench',
//         'SysNotice',
        'Contacts',
        'Website',
        'http://ws.pulata.com.cn:8888/login'
    ],
    'assign-buyer'=>[
        'Workbench',
//         'SysNotice',
        'Contacts',
        'Website',
        'WarehousingProcess',
        'PurchaseList',
        'http://ws.pulata.com.cn:8888/login',
        'Refund'
    ],
    'assign-buyer-manager' => [
        'WarehousingProcess',
        'PurchaseList',
        'Workbench',
//         'SysNotice',
        'Contacts',
        'Website',
        'http://ws.pulata.com.cn:8888/login',
        'Refund'
    ],
    
    'assign-manager'=>[
        'StockDetails',
        'StockSum',
        'StockWarning',
        'ShelvesManagement',
        'DistributionCenter',
        'DistributionDelivery',
        'GoodsInspect',
        'DeliverGoods',
        'ExpressReceive',
        'ExpressCompany',
        'ExpressCompensation',
        'CartonManagement',
        'Workbench',
//         'SysNotice',
        'Contacts',
        'Website',
        'OrderList',
        'Mail',
        'SalesGoodsStatistics',
        'SampleApplication',
        'http://ws.pulata.com.cn:8888/login',
        'Refund'
    ],
    'assign-captain'=>[
        'StockDetails',
        'StockSum',
        'StockWarning',
        'ShelvesManagement',
        'DistributionCenter',
        'DistributionDelivery',
        'GoodsInspect',
        'DeliverGoods',
        'ExpressReceive',
        'ExpressCompany',
        'ExpressCompensation',
        'CartonManagement',
        'Workbench',
//         'SysNotice',
        'Contacts',
        'Website',
        'Mail',
        'http://ws.pulata.com.cn:8888/login',
        'Refund',
        'OrderList'
    ],
    'assign-staff'=>[
        'StockDetails',
        'StockSum',
        'StockWarning',
        'ShelvesManagement',
        'DistributionCenter',
        'DistributionDelivery',
        'GoodsInspect',
        'DeliverGoods',
        'ExpressReceive',
        'ExpressCompany',
        'ExpressCompensation',
        'CartonManagement',
        'Workbench',
//         'SysNotice',
        'Contacts',
        'Website',
        'Mail',
        'http://ws.pulata.com.cn:8888/login',
        'Refund',
        'OrderList'
    ],
    'assign-service'=>[
        'StockDetails',
        'StockSum',
        'StockWarning',
        'ShelvesManagement',
        'DistributionCenter',
        'DistributionDelivery',
        'GoodsInspect',
        'DeliverGoods',
        'ExpressReceive',
        'ExpressCompany',
        'ExpressCompensation',
        'CartonManagement',
        'Workbench',
//         'SysNotice',
        'Contacts',
        'Website',
        'OrderList',
        'http://ws.pulata.com.cn:8888/login',
        'Refund'
    ],
    'finance'=>[
        'SalesPerformance',
        'SalesQuantization',
        'Workbench',
//         'SysNotice',
        'Contacts',
        'Website',
        'WarehousingProcess',
        'PurchaseList',
        'SalesGoodsStatistics',
        'SampleApplication',
        'http://ws.pulata.com.cn:8888/login'
    ],
    'stration' => [
       'QuestionnaireManagement',
        'AccountSettings'
    ],
    
    // 隐藏的角色 不起作用
    'group-member' => [],
    'department-manager' => [],
    'group-captain' => [],
    'sale-department-member' => [],
    'assign-department-member' => []
];
