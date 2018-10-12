<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JdOrderBasic extends Model
{
    use SoftDeletes;

    protected $table = 'jd_order_basic';

    protected $dates = ['deleted_at'];

    protected $hidden = [ 'updated_at','deleted_at'];

    protected $fillable = [
        "order_sn",
        "order_account",
        "order_at",
        "order_money",
        "all_money",
        "pay_money",
        "pay_balance",
        "status",
        "type",
        "remark",
        "express_fee",
        "pay_way",
        "pay_confirm_at",
        "end_at",
        "order_source",
        "order_channel",
        "install_service",
        "service_fee",
        "is_brand",
        "is_toplife"
    ];

    //头部字段
    public static $fieldsName = [
    	"order_sn",
        "goods_id",
        "goods_name",
        "goods_num",
        "pay_way",
        "order_at",
        "goods_price",
        "order_money",
        "all_money",
        "pay_balance",
        "pay_money",
        "status",
        "type",
        "order_account",
        "cus_name",
        "address",
        "tel",
        "remark",
        "invoice_type",
        "invoice_head",
        "invoice_content",
        "shop_remark",
        "shop_remark_level",
        "express_fee",
        "pay_confirm_at",
        "add_tax_invoice",
        "sku_sn",
        "end_at",
        "order_source",
        "order_channel",
        "install_service",
        "service_fee",
        "entrepot_id",
        "entrepot_name",
        "general_invoice_tax",
        "shop_sku_id",
        "email",
        "zip_code",
        "is_brand",
        "is_toplife"
    ];


    /**
     * 关联的商品
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function goods()
    {
        return $this->hasMany('App\Models\JdOrderGoods', 'order_sn','order_sn');
    }

    public function other(){
    	return $this->hasMany('App\Models\JdOrderOther', 'order_sn','order_sn');
    }

    public function customer(){
    	return $this->belongsTo('App\Models\JdOrderCustomer', 'order_sn','order_sn');
    }

    public function address(){
    	return $this->belongsTo('App\Models\JdOrderAddress', 'order_sn','order_sn');
    }









}
