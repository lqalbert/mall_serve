<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActualDeliveryExpress extends Model
{
    use SoftDeletes;

    protected $table = 'actual_delivery_expresses';

    protected $dates = [
        'deleted_at'
    ];
    protected $hidden = ['created_at', 'updated_at','deleted_at'];
    protected $fillable = [

        'purchase_order_id',
        'postage',
        'express_num',
        'express_company',
        'total_case_num',
        'confirm_user',
        'deliver_goods_time',
        'remarks',

    ];
    public function ActualGoods()
    {
        return $this->hasMany('App\Models\ActualDeliveryGoods', 'actual_delivery_expresses_id');
    }
}
