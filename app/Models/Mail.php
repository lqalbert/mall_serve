<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mail extends Model
{
    use SoftDeletes;
    protected $table="mails";
    protected $hidden = [
        'password',
        'updated_at',
        'deleted_at'
    ];
    protected $dates = [
        'deleted_at'
    ];
    protected $fillable = [
        'name',
        'phone',
        'express_id',
        'express_name',
        'express_sn',
        'area_province_id',
        'area_city_id',
        'area_district_id',
        'area_province_name',
        'area_city_name',
        'area_district_name',
        'address',
        'remark',
        'type',
    ];
}
