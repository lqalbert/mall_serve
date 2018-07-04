<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseOrder extends Model
{
    use SoftDeletes;

    protected $table = 'purchase_orders';

    protected $dates = [
        'deleted_at'
    ];
    protected $hidden = ['created_at', 'updated_at','deleted_at'];
    protected $fillable = [
        'id',
        'shipper',
        'order_sn',
        'entrepot_id',
        'entrepot_name',
        'contact_time',
        'contact_name',
        'contact_phone',
        'sku_type',
        'goods_total',
        'goods_money_total',
        'postage',
        'purchase_status',
        'warehousing_status',
        'settlement_status',
        'remark',
    ];
    public function goods()
    {
        return $this->hasMany('App\Models\PurchaseOrderGoods', 'purchase_order_id');
    }
    public function actual_delivery_goods()
    {
        return $this->hasMany('App\Models\ActualDeliveryGoods', 'purchase_order_id');
    }
    
    public function entrepot()
    {
        return $this->belongsTo('App\Models\DistributionCenter');
    }
}
