<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Events\OrderCreating;
class OrderBasic extends Model
{
    use SoftDeletes;
    protected $table = 'order_basic';
    protected $dates = [
        'deleted_at'
    ];
    protected $hidden = ['created_at', 'updated_at','deleted_at'];
    protected $fillable = [
        'deal_id',
        'deal_name',
        'address_id',
        'goods_id',
        'cus_id',
//         'exchange',
//         'order_goods',
        'order_all_money',
        'order_pay_money',
        'check_status',
        'order_sn',
        'entrepot_id'
    ];
    
    /**
     * 模型的事件映射
     * 
     * @var array
     */
    protected $events = [
        'creating' => OrderCreating::class
    ];
    
    
    /**
     * 关联的商品
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function goods()
    {
        return $this->hasMany('App\Models\OrderGoods', 'order_id');
    }
    
    public function entrepot()
    {
        return $this->belongsTo('App\Models\DistributionCenter');
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
}
