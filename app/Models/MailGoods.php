<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MailGoods extends Model
{
    protected $table = 'mail_goods';
    
    protected $fillable = [
        'mail_id',
        'goods_id',
        'sku_id',
        'sku_sn',
        'goods_name',
        'sku_name',
        'price',
        'remark',
        'unit_type',
        'width',
        'height',
        'len',
        'barcode',
        'weight',
        'bubble_bag',
        'specifications'
    ];
}
