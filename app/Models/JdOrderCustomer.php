<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JdOrderCustomer extends Model
{
//     use SoftDeletes;
    
    const NOTMATCH = 0;
    const MATCHING = 1;
    const MATCHED = 2;

    protected $table = 'jd_order_customer';

//     protected $dates = ['deleted_at'];

    protected $hidden = [ 'updated_at','deleted_at'];

    protected $fillable = [
        "order_sn",
        "cus_name",
        "tel",
        "order_account",
        "flag",
        "is_brusher",
        'cus_id'
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
