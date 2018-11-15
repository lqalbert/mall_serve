<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JdOrderOther extends Model
{
//     use SoftDeletes;
    
    protected $table = 'jd_order_other';

//     protected $dates = ['deleted_at'];

    protected $hidden = [ 'updated_at','deleted_at'];

    protected $fillable = [
        "order_sn",
        "invoice_type",
        "invoice_head",
        "invoice_content",
        "shop_remark",
        "shop_remark_level",
        "add_tax_invoice",
        "general_invoice_tax",
        "shop_sku_id"
    ];

    /**
     * 关联的JD订单
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function order()
    {
        return $this->belongsTo('App\Models\JdOrderBasic', 'order_sn','order_sn');
    }







    
}
