<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class OrderBasic extends Model
{
    use SoftDeletes;
    protected $table = 'order_basic';
    protected $dates = [
        'deleted_at'
    ];
    protected $hidden = ['created_at', 'updated_at','deleted_at'];
    protected $fillable = [
        'category_id',
        'goods_id',
        'cus_id',
        'goods_number',
        'remark'
    ];
}
