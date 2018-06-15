<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseOrderGoods extends Model
{
    use SoftDeletes;

    protected $table = 'purchase_order_goods';

    protected $dates = [
        'deleted_at'
    ];
    protected $hidden = ['created_at', 'updated_at','deleted_at'];
    protected $fillable = [
        'purchase_order_id',
        'sku_sn',
        'category',
        'goods_id',
        'specifications',
        'goods_name',
        'goods_purchase_num',
        'goods_purchase_price',
    ];

}
