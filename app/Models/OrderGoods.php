<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Contracts\Goods as GoodsContracts;

class OrderGoods extends Model implements GoodsContracts
{
    const STATUS_RETURN = 1;
    const STATUS_EXCHANGE  =2;
    use SoftDeletes;
    protected $table = 'order_goods';
    protected $dates = [
        'deleted_at'
    ];
    //'created_at',
    protected $hidden = [ 'updated_at','deleted_at'];
    protected $fillable = [
        'order_id',
        'goods_id',
        'goods_name',
        'price',
        'goods_number',
        'remark',
        'exchange_status',
        'sku_id',
        'sku_name',
        'sku_sn',
        'unit_type',
        'len',
        'width',
        'height',
        'barcode',
        'weight',
        'bubble_bag',
        
        'reason',
        'status',
        'inventory',
        'return_num',
        'specifications'
    ];
    
    public function productCategory()
    {
        return $this->belongsTo('App\Models\EntrepotProductCategory', 'sku_sn', 'sku_sn');
    }
    
    public function order()
    {
        return $this->belongsTo('App\Models\OrderBasic', 'order_id');
    }
    
    public function assign()
    {
        return $this->hasOne('App\Models\Assign', 'order_goods_id')->select(['id','order_goods_id','out_entrepot_at','sign_at']);
    }
    
    public function getNum()
    {
        return $this->attributes['goods_number'];
    }
    
    public function getSkuSn()
    {
        return $this->attributes['sku_sn'] ;    
    }
    public function getName(){
        return $this->attributes['goods_name'];
    }
    
    public function isExchange()
    {
        return $this->status == self::STATUS_EXCHANGE;
    }
    
    public function setExchangeStatus()
    {
        $this->status = self::STATUS_EXCHANGE;
    }
    
    //多对多
    public function category()
    {
        //->withTimestamps()
        return $this->belongsToMany('App\Models\Category', 'goods_categories', 'goods_id', 'cate_id');
    }
}
