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
    
    public function cateogry() 
    {
        return $this->belongsToMany('App\Models\Category', 'goods_categories', 'goods_id', 'cate_id');
    }
    
    public function imgs() 
    {
        return $this->hasMany('App\Models\GoodsImg', 'goods_id');
    }
}
