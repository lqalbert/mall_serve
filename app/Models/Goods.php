<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Goods extends Model
{
    use SoftDeletes;
    
    protected $dates = [
        'deleted_at'
    ];
    
    protected  $table = "goods_basic";
    
    
    protected $fillable= [
    		'goods_name',
    		'goods_price',
    		'goods_number',
    		'unit_type',
    		'description',
    		'cover_url',
    		'status',
    ];
    
    public function category() 
    {
        return $this->belongsToMany('App\Models\Category', 'goods_categories', 'goods_id', 'cate_id');
    }
    
    public function midCate(){
    	return $this->hasMany('App\Models\GoodsCategory');
    }
    
    public function imgs() 
    {
        return $this->hasMany('App\Models\GoodsImg', 'goods_id');
    }
    
    /**
     * 获取封面图片。
     *
     * @param  string  $value
     * @return string
     */
    public function getCoverUrlAttribute($value)
    {
    	return asset($value);
    }
}
