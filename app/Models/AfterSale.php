<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Events\AfterCreated;

class AfterSale extends Model
{
    use SoftDeletes;
    
    
    const RETURN_BACK = 0;
    const EXCHANGE_GOODS  = 1;
    
    protected $table = 'order_after';
    
    protected $dates = [
        'deleted_at'
    ];
    
//     protected $guarded = [
//         'goods',
//         'return_cause_id',
//         'goods_num'
//     ];
    
    protected $fillable = [
        'order_id',
        'order_sn',
        'entrepot_id',
        'cus_id',
        'return_unit',
        'return_fee',
        'receive_unit',
        'resend_unit',
        'express',
        'express_sn',
        'service_fee',
        'pay_at_return',
        'is_special',
        'fee',
        'user_name',
        'user_id',
        'remark'
    ];
    
    protected $events = [
      'created' => AfterCreated::class  
    ];
    
    
    public function goods()
    {
        return $this->hasMany('App\Models\OrderGoods', 'order_id');
    }
    
    public function entrepot()
    {
        return $this->belongsTo('App\Models\DistributionCenter');
    }
    
    
    public function order()
    {
        return $this->belongsTo('App\Models\OrderBasic', 'order_id');
    }
    
    public function getCheckStatusTextAttribute()
    {
        $map = ['待审核', '通过', '不通过'];
        return $map[$this->attributes['check_status']];
    }
    
    public function getType0TextAttribute()
    {
        $map = ['退货', '换货'];
        return $map[$this->attributes['type']];
    }
}
