<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Contracts\Goods as GoodsContracts;

class OrderGoods extends Model implements GoodsContracts
{
    const STATUS_RETURN = 1;
    const STATUS_EXCHANGE  =2;
    const STATUS_EXCHANGE_SEND  =3;
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
        'specifications',
        'assign_id',
        'destroy_num'
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
    
    public function isReturn()
    {
        return $this->status == self::STATUS_RETURN;
    }
    
    public function setExchangeStatus()
    {
        $this->status = self::STATUS_EXCHANGE;
    }
    
    public function setResendSatus()
    {
        $this->status = self::STATUS_EXCHANGE_SEND;
    }
    
    public function goods()
    {
        return $this->belongsTo('App\Models\Goods',  'goods_id')->select('id')->with('category');
    }
    
    public function getCategoryAttribute()
    {
        return $this->goods->category;
    }
    
    public function getStatusTextAttribute()
    {
        $map = ["正常", "退货", "换货", "换货重发"];
        return $map[$this->status];
    }
    
    public function getSaledPriceAttribute()
    {
        $orderType = $this->order->typeObjecToOrderType();
        return $orderType->getDiscounted($this->price);
    }
    
    /**
     * 退换货的
     * @param unknown $query
     * @return unknown
     */
    public function scopeAfter($query)
    {
        return $query->where('status', self::STATUS_RETURN)->orWhere('status', self::STATUS_EXCHANGE);
    }
}
