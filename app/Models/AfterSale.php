<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Events\AfterCreated;
use Carbon\Carbon;
use App\Models\Scopes\IdDesc;

class AfterSale extends Model
{
    use SoftDeletes;
    
    
//     const RETURN_BACK = 0;
//     const EXCHANGE_GOODS  = 1;
    
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
        'remark',
        'resend_fee',
        'reservice_fee',
        'inventory_state'
    ];
    
    protected $events = [
      'created' => AfterCreated::class  
    ];
    
    
    public function goods()
    {
        return $this->hasMany('App\Models\OrderGoods', 'order_id', 'order_id')->after();
    }
    
    public function entrepot()
    {
        return $this->belongsTo('App\Models\DistributionCenter');
    }
    
    
    public function order()
    {
        return $this->belongsTo('App\Models\OrderBasic', 'order_id')->withTrashed();
    }
    
    public function getCheckStatusTextAttribute()
    {
        $map = ['待审核', '通过', '不通过'];
        return $map[$this->attributes['check_status']];
    }
    
    public function getTypeTextAttribute()
    {
        $map = ['退货', '换货'];
        return $map[$this->attributes['type']];
    }
    
    public function getInventoryStateTextAttribute()
    {
        $map = ['未操作', '已操作'];
        return $map[$this->inventory_state];
    }
    
    public function setSure()
    {
//         $data['sure_at'] = Carbon::now();
        $this->sure_at = Carbon::now();
        $this->status = 2;
        
    }

    public function setInventoryed()
    {
        $this->inventory_state = 1;
    }
    
    protected static function boot()
    {
        parent::boot();
        
        static::addGlobalScope(new IdDesc());
    }

}
