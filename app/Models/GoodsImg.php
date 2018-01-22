<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GoodsImg extends Model
{
	use SoftDeletes;
    
	protected $table="goods_imgs";
	
	protected $fillable = [
		'goods_id',
		'url',
	];
	 /**
	   * 在数组中想要隐藏的属性。
	   *
	   * @var array
	   */
	 protected $hidden = ['created_at', 'updated_at','deleted_at'];
}
