<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JdOrderAddress extends Model
{
    use SoftDeletes;
    
    protected $table = 'jd_order_address';

    protected $dates = ['deleted_at'];

    protected $hidden = [ 'updated_at','deleted_at'];

    protected $fillable = [
        "order_sn",
        "cus_name",
        "address",
        "tel",
        "zip_code",
        "email"
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
