<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sku extends Model
{
	
	protected $table = 'goods_sku';
	
    use SoftDeletes;
    
	protected $dates = [
			'deleted_at'
	];
	
	protected $fillable = [
			'name',
			'num',
			'price',
			'goods_id'
	];
	
	
	
	//1对多
	public function attr()
	{
		return $this->belongsToMany('App\Models\GoodsSpecs', 'sku_attrs', 'sku_id', 'spec_id')
					->withPivot(['goods_id','value','addon_value']);
	}
	
// 	public function getImgUrlAttribute()
// 	{
// 		return assert($this->attributes[''])
// 	}
}
