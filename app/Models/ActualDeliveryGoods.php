<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Contracts\Goods as GoodsContracts;


class ActualDeliveryGoods extends Model implements GoodsContracts
{
    use SoftDeletes;

    protected $table = 'actual_delivery_goods';

    protected $dates = [
        'deleted_at'
    ];
    protected $hidden = ['created_at', 'updated_at','deleted_at'];
    protected $fillable = [
        'purchase_order_id',
        'actual_delivery_expresses_id',
        'express_num',
        'sku_sn',
        'category',
        'goods_id',
        'specifications',
        'goods_name',
        'actual_goods_num',
        'every_case_goods_num',
        'goods_case_num',
        'goods_case_weight',
        'goods_manufacture_time',


    ];
    
    
    public function purchase()
    {
        return $this->belongsTo('App\Models\PurchaseOrder', 'purchase_order_id');
    }
    
    public function getSkuSn()
    {
        return $this->attributes['sku_sn'];
    }
    
    public function getNum()
    {
        return $this->attributes['actual_goods_num'];
    }
    
    public function getName()
    {
        return $this->attributes['goods_name'];
    }
    
    
}
