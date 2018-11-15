<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JdOrderBasic extends Model
{
    use SoftDeletes;

    const IS_BRUSHER = 1;//刷单
    const MATCH_FALSE = 2;

    protected $table = 'jd_order_basic';

    protected $dates = ['deleted_at'];

    protected $hidden = [ 'updated_at','deleted_at'];
    
    protected $appends = ['prefix_order_sn','match_text'];

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
        "is_toplife",
        "department_id",
        "group_id",
        "user_id",
        'flag',
        'is_brusher',
        'cus_id',
        'entrepot_id'
    ];

    protected $guarded = [];
    
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
        "jd_entrepot_id",
        "jd_entrepot_name",
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
        return $this->hasOne('App\Models\JdOrderOther', 'order_sn','order_sn');
    }

    public function customer(){
        return $this->hasOne('App\Models\JdOrderCustomer', 'order_sn','order_sn');
    }

    public function address(){
        return $this->hasOne('App\Models\JdOrderAddress', 'order_sn','order_sn');
    }

    //关联部门
    public function department(){
        return $this->belongsTo('App\Models\Department', 'department_id');
    }

    //关联小组
    public function group(){
        return $this->belongsTo('App\Models\Group', 'group_id')->select(['id','name']);
    }

    //关联销售员工
    public function user(){
        return $this->belongsTo('App\Models\User', 'user_id')->select(['id','realname','group_id']);
    }
    
    public function entrepot()
    {
        return $this->belongsTo('App\Models\DistributionCenter');
    }
    
    public function setDepositReturn($on=true)
    {
        if ($on) {
            $this->is_deposit_return = 1;
        } else {
            $this->is_deposit_return = 0;
        }
        
    }
    
    public function isDepositReturn()
    {
        return $this->is_deposit_return == 1;
    }
    
    public function isNoSence()
    {
        return $this->is_brusher == 1;
    }
    
    public function isReturnInventory()
    {
        return $this->is_deduce_inventory == 1;
    }
    
    public function setduceInventory($on=true)
    {
        if ($on) {
            $this->is_deduce_inventory = 1;
        } else {
            $this->is_deduce_inventory = 0;
        }
    }
    
    public function getPrefixOrderSnAttribute()
    {
        return 'JD'.$this->order_sn;
    }
    
    public function setMatchState($on=true)
    {
        if ($on) {
            $this->match_state = 1;
        } else {
            $this->match_state = 2;
        } 
    }
    
    public function getMatchTextAttribute()
    {
        $map = ['未分配','已分配','失败'];
        return $map[$this->match_state];
    }






}
