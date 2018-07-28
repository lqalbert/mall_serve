<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use App\Events\OrderCreating;
use App\Events\OrderCreated;

class OrderBasic extends Model
{
    use SoftDeletes;
    
    CONST UN_CHECKED =0;
    CONST WATI_TO_CHANGR =2;
    CONST CANCEL = 7;
    
    CONST AFTER_SALE_TYPE_RETURN = 0;
    CONST AFTER_SALE_TYPE_EXCHANGE = 1;
    
    CONST AFTER_SALE_RETURN_DONE = 13;
    CONST AFTER_SALE_EXCHANGE_DONE = 23;
    CONST ORDER_STATUS_7 = 7;
    CONST ORDER_STATUS_8 = 8;

    
    protected $table = 'order_basic';
    protected $dates = [
        'deleted_at'
    ];
    protected $hidden = [ 'updated_at','deleted_at'];
    protected $fillable = [
        'deal_id',
        'deal_name',
        'dep_group_realname',
        'address_id',
        'goods_id',
        'cus_id',
//         'exchange',
//         'order_goods',
        'order_all_money',
        'discounted_goods_money',
        'order_pay_money',
        'check_status',
        'order_sn',
        'entrepot_id',
        'cus_name',
        'group_id',
        'department_id',
        'express_delivery',
        'express_id',
        'order_remark',
        'express_remark',
        'express_name',
        'type',
        'user_id',
        'user_name',
        'group_name',
        'department_name',
        'include_freight',
        'freight'
    ];
    
    /**
     * 模型的事件映射
     * 
     * @var array
     */
    protected $events = [
//         'creating' => OrderCreating::class,

        'created'  => OrderCreated::class
    ];
    
    /**
     * 订单状态
     * 索引
     * @var array
     */
    private static $status = [
        "待审核",
        "审核通过",
        "发货中",
        "已发货",
        "已揽件",
        "运输中",
        "订单完成",
        "订单取消",
        "审核未通过"
    ];
    
    /**
     * 货物状态
     * @var array
     */
    private static $productStatus = [
        "未处理",
        "配货中",
        "已发货",
        "已签收"
    ];
    
    
    /**
     * 售后状态
     * @var array
     */
    private static $afterSaleStatus = [
        "l0"=>"无",
        "l10"=>"申请退货",
        //"l11"=>"退货审核通过",
        "l11"=>"退货不通过",
        "l12"=>"退货中",
        "l13"=>"退货完成",
        
        
        "l20"=>"申请换货",
        //"l21"=>"换货审核通过",
        "l21"=>"换货不通过",
        "l22"=>"换货中",
        "l23"=>"换货完成"
                       
    ];
    
    /**
     * 关联的商品
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function goods()
    {
        return $this->hasMany('App\Models\OrderGoods', 'order_id');
    }
    
    /**
     * 关联订单地址
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function address(){
        return $this->hasOne('App\Models\OrderAddress','order_id');
    }

    public function entrepot()
    {
        return $this->belongsTo('App\Models\DistributionCenter');
    }
    
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
    
    //auditor_id
    public function auditor()
    {
        return $this->belongsTo('App\Models\User', 'auditor_id');
    }
    
    public function customer()
    {
        return $this->belongsTo('App\Models\CustomerBasic', 'cus_id');
    }
    
    public function department()
    {
        return $this->belongsTo('App\Models\Department', 'department_id');
    }
    
    public function getGoods()
    {
        return $this->goods;
    }
    
    /**
     * 是否通过
     * 这里先直接返回 false 还没有
     * @todo 修改成正式的代码
     * 
     * @return bool
     */
    public function isAssign()
    {
        return Assign::where('order_id', $this->id)->select('id')->first();
    }
    
    /**
     * 是否通过审核
     */
    public function isPass()
    {
        return $this->status >= 1 ;
    }
    
    public function isSetExpress()
    {
        return $this->express_delivery ? $this->express_delivery : false ;
    }
    
    
    public function updateStatusToWaitCharge()
    {
        $this->status = 2;
        return $this->save();
    }
    
    public function updateAfterSaleDone($type) 
    {
        if ($type == self::AFTER_SALE_TYPE_RETURN) {
            $this->after_sale_status = self::AFTER_SALE_RETURN_DONE;
        } else if($type == self::AFTER_SALE_TYPE_EXCHANGE) {
            $this->after_sale_status = self::AFTER_SALE_EXCHANGE_DONE;
        }
    }
    
    /**
     * 返回菜鸟接口要求的结构化的数据
     * @return unknown
     */
    public function getRecipient()
    {
        return $this->address->getRecipient();
    }
    
    
    
    
    /**
     * 获取订单数量
     * 注意要在事务里面使用 
     * @static 
     * 
     * @param int $entrepot_id
     * 
     * @return integer
     */
    public static function getOrderCount($entrepot_id)
    {
        return self::withTrashed()->where('entrepot_id', $entrepot_id)
        ->lockForUpdate()->count();
    }
    
    /**
     * 订单状态文字描述
     * getStatusTextAttribute
     * @return string
     */
    public function getStatusTextAttribute()
    {
        return self::$status[$this->attributes['status']];
    }
    
    /**
     * 货物状态文字描述
     * @return string
     */
    public function getProductStatusTextAttribute()
    {
        return self::$productStatus[$this->attributes['product_status']];
    }
    
    public function getAfterSaleStatusTextAttribute()
    {
        return self::$afterSaleStatus["l".$this->attributes['after_sale_status']];
    }
    
    public function getTypeTextAttribute()
    {
        $map = ['销售订单','内部订单','商城订单'];
        return $map[$this->type];
    }
    
    public function orderType()
    {
        return $this->belongsTo('App\Models\OrderType' ,'type')->select('id','name');
    }
}
