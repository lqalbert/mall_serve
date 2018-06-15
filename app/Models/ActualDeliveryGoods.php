<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActualDeliveryGoods extends Model
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
}
