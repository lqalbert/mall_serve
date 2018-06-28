<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExpressPrice extends Model
{
    use SoftDeletes;
    const IS_USE = 1;
    protected $table ='express_prices';
    protected $fillable=[
        'area_province_name',
        'area_city_name',
        'area_district_name',
        'area_province_id',
        'area_city_id',
        'area_district_id',
        'time_limit',
        'first_weight',
        'first_price',
        'continued_weight',
        'continued_price',
        'start_time',
        'end_time',
        'is_use',
        'remark',
        'express_id',
        'express_name'
    ];
    protected $hidden = ['created_at', 'updated_at','deleted_at'];
    protected $dates = [
        'deleted_at'
    ];
}
