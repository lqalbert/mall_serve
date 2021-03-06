<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JdOrderGoods extends Model
{
//     use SoftDeletes;
    const NOT_MINUS = 0;
    const MINUSING = 1;
    const MINUSED = 2;
    const MINUS_SUCCESS = 1;
    const MINUS_FAILED = 2;

    protected $table = 'jd_order_goods';

//     protected $dates = ['deleted_at'];

    protected $hidden = [ 'updated_at','deleted_at'];

    protected $fillable = [
        "order_sn",
        "goods_id",
        'sku_sn',
        "goods_name",
        "goods_num",
        "goods_price",
        "entrepot_id",
        "jd_entrepot_id",
        "jd_entrepot_name",
        'flag',
        'is_brusher',
        'is_minus'
    ];

    /**
     * 关联的JD订单
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function order()
    {
        return $this->belongsTo('App\Models\JdOrderBasic', 'order_sn','order_sn');
    }
    
    public function originGoods()
    {
        return $this->belongsTo('App\Models\Goods', 'sku_sn', 'sku_sn')->select('sku_sn','goods_name');
    }
    
    public function getSkuSn()
    {
        return $this->sku_sn;
    }
    
    public function getName()
    {
        return $this->goods_name;
    }
    
    public function getNum()
    {
        return $this->goods_num;
    }






}
