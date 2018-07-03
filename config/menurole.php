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
    'assign-buyer'=>[
        'WarehousingProcess',
        'PurchaseList'
    ],
    'assign-buyer-manager' => [
        'WarehousingProcess',
        'PurchaseList'
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
        'CartonManagement'
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
        'CartonManagement'
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
        'CartonManagement'
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
        'CartonManagement'
    ],
    
    // 隐藏的角色
    'group-member' => [],
    'department-manager' => [],
    'group-captain' => [],
    'sale-department-member' => []
];