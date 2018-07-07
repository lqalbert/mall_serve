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
        'Workbench',
        'SysNotice',
        'Contacts',
        'Website',
        'WarehousingProcess',
        'PurchaseList'
    ],
    'assign-buyer-manager' => [
        'WarehousingProcess',
        'PurchaseList',
        'Workbench',
        'SysNotice',
        'Contacts',
        'Website',
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
        'SysNotice',
        'Contacts',
        'Website',
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
        'SysNotice',
        'Contacts',
        'Website',
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
        'SysNotice',
        'Contacts',
        'Website',
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
        'SysNotice',
        'Contacts',
        'Website',
    ],
    
    // 隐藏的角色
    'group-member' => [],
    'department-manager' => [],
    'group-captain' => [],
    'sale-department-member' => []
];