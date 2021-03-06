<?php
return [

        [
            'text'=>'工作台管理',
            'icon'=>null,
            'subIndex'=>['Workbench','SysNotice','Contacts','Website','SlideManage','http://ws.pulata.com.cn:8888/login']
        ],


		[
				'text'=>'商品管理',
				'icon'=>null,
				'subIndex'=>['GoodsDetails','Category','GoodsSpecs','GoodsType','FrontCategory']
		],
		[
				'text'=>'员工管理',
				'icon'=>null,
		        'subIndex'=>['Department','Group','Employee','EarnestMoney'] //'Deposit','OrderDepositLog'
		],
// 		[
// 				'text'=>'客户管理',
// 				'icon'=>null,
// 				'subIndex'=>[]
// 		],
		[
				'text' => '客户订单',
				'icon'=>null,
		    'subIndex'=>['Customer','OrderList', 'Refund', 'OrderType', 'SampleApplication','ImportJdOrder','JdOrderBasic'] // 'Refund' 'JdOrderBasic'
		],
		[
				'text' => '库存管理',
				'icon' => null,
				'subIndex' => ['StockDetails','StockSum','StockWarning','ShelvesManagement']
		    //'InventoryList',13,'StockOutDetails','WarehousingProcess'
		],
		[
				'text' => '配送管理',
				'icon' => null,
				'subIndex' => ['DistributionCenter','DistributionDelivery','GoodsInspect','DeliverGoods','ExpressReceive','ExpressCompany','ExpressCompensation','CartonManagement','FreightTemplate','Mail']
		    //'ExpressInfo',
		],
		[
				'text' => '资讯管理',
				'icon' => null,
				'subIndex' => ['Articles']
		],
// 		[
// 				'text' => '护肤资讯',
// 				'icon' => null,
// 				'subIndex' => ['SkinCareInfo']
// 		],
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
		[
			    'text' => '统计报表',
			    'icon' => null,
			    'subIndex'=>['SalesPerformance','SalesQuantization','SalesGoodsStatistics']
		],
        [
			    'text' => '问卷管理',
			    'icon' => null,
			    'subIndex'=>['QuestionnaireManagement','AccountSettings']
		],
//         [
//                 'text' => '预充值管理',
//                 'icon' => null,
//                 'subIndex' => []
//         ]
        [
            'text' => '护理方案',
            'icon' => null,
            'subIndex' => ['Efficacy']
        ]
];
