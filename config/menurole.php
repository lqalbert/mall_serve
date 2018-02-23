<?php
/**
 * menugs 里面的索引
 */
return [
		'administrator'=>['*'],
		'super-manager'=>['*'],
		'sale-manager' =>[0,5,6,8,9,10,11],
		'sale-captain' =>[0,6,8,9],
		'sale-staff'   =>[0,8,9],
	//隐藏的角色
	    'group-member' =>[],
		'department-manager'=>[],
		'group-captain'=>[],
		'sale-department-member'=>[]
];