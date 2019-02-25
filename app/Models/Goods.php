<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Contracts\Goods as GoodsContracts;

class Goods extends Model implements GoodsContracts
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
		'subtitle',
		'brief',
		'goods_sn',
        'sku_sn',
        'new_goods',
        'hot_goods',
        'del_price',
        'comments',
        'sale_count',
        'sale_able_count',
        'len',
        'width',
        'height',
        'barcode',
        'weight',
        'bubble_bag',
        'specifications',
        'combo',
        'is_appendage',
        'efficacy'
    ];
    
    //多对多
    public function category() 
    {
        //->withTimestamps()
        return $this->belongsToMany('App\Models\Category', 'goods_categories', 'goods_id', 'cate_id');
    }
    
    public function midCate(){
    	return $this->hasMany('App\Models\GoodsCategory');
    }
    
    //多对多
    public function frontCategory()
    {
        //->withTimestamps()
        return $this->belongsToMany('App\Models\CategoryFront', 'front_goods', 'goods_id', 'front_id');
    }
    
    public function midFrontCate(){
        return $this->hasMany('App\Models\GoodsFrontCategory');
    }
    
    //1对多
    public function imgs() 
    {
        return $this->hasMany('App\Models\GoodsImg', 'goods_id');
    }
    
    //1对多
    public function skus()
    {
    	return $this->hasMany('App\Models\Sku', 'goods_id');
    }
    
    public function combos()
    {
        return $this->hasMany('App\Models\GoodsCombo', 'combo_id');
    }
    
    //1对多
    public function attrs()
    {
    	return $this->belongsToMany('App\Models\GoodsSpecs', 'sku_attrs', 'goods_id', 'spec_id');
    }
    
    public function derectAttr()
    {
        return $this->hasMany("App\Models\SkuAttr", 'goods_id');
    }
    
//     public function getGoodsPriceAttribute($value)
//     {
//         $value = number_format($value,2,'.','');
//         if ($value == "0.00") {
//             return '敬请关注';
//         } else {
//             return $value;
//         }
//     }

    public function getPrice()
    {
        $value = number_format($this->goods_price,2,'.','');
        if ($value == "0.00") {
            return '敬请关注';
        } else {
            return $value;
        }
    }

    public function getSkuSn()
    {
        return $this->sku_sn;
    }
    
    public function getName()
    {
        return $this->goods_name;
    }
    
    /**
     * 套装入库出库时需要
     * @return int
     */
    public function getNum()
    {
        return $this->combo_num;
    }
    
    /**
     * 是不是 套餐
     * @return boolean
     */
    public function isThisACombo()
    {
        return $this->combo == 1 ;
    }
    
    
    /**
     * 获取封面图片。
     *
     * @param  string  $value
     * @return string
     
    public function getCoverUrlAttribute($value)
    {
        if($value){
            $value = asset($value);
        }
    	return $value;
    }*/
    
    public static function getCount()
    {
    	return self::withTrashed()->count();
    }
    
    /**
     * 限制查询只包括上架。
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
    
    /**
     * 这个名称写错了 不应该是 iscombo
     * 而是 isincludecombo
     * @param unknown $query
     * @param string $include
     * @return unknown
     */
    public function scopeIsCombo($query, $include = false)
    {
        return $query->where('combo', $include ? 1 : 0);
    }
}
