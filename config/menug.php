<?php
return [

        [
            'text'=>'工作台管理',
            'icon'=>null,
            'subIndex'=>['Workbench','SysNotice','Contacts','Website']
        ],


		[
				'text'=>'商品管理',
				'icon'=>null,
				'subIndex'=>['GoodsDetails','Category','GoodsSpecs','GoodsType']
		],
		[
				'text'=>'员工管理',
				'icon'=>null,
				'subIndex'=>['Department','Group','Employee','Deposit']
		],
// 		[
// 				'text'=>'客户管理',
// 				'icon'=>null,
// 				'subIndex'=>[]
// 		],
		[
				'text' => '客户订单',
				'icon'=>null,
		        'subIndex'=>['Customer','OrderList', 'Refund'] // 'Refund'
		],
		[
				'text' => '库存管理',
				'icon' => null,
				'subIndex' => ['StockDetails','StockSum','StockOutDetails','StockWarning','ShelvesManagement','WarehousingProcess']
		    //'InventoryList',13
		],
		[
				'text' => '配送管理',
				'icon' => null,
				'subIndex' => ['DistributionCenter','DistributionDelivery','GoodsInspect','DeliverGoods','ExpressReceive','ExpressCompany','ExpressCompensation','CartonManagement']
		    //'ExpressInfo',
		],
		[
				'text' => '资讯管理',
				'icon' => null,
				'subIndex' => ['Articles']
		],
		[
				'text' => '护肤资讯',
				'icon' => null,
				'subIndex' => ['SkinCareInfo']
		],
		[
				'text' => '留言管理',
				'icon' => null,
				'subIndex'=>['Connection']
		],
		[
				'text' => '盘点管理',
				'icon' => null,
				'subIndex'=>['StockCheckGoods','StockCheck']
		],
		[
			    'text' => '采购管理',
			    'icon' => null,
			    'subIndex'=>['WarehousingProcess','PurchaseList']
		],
];
