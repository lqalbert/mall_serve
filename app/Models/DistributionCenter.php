<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class DistributionCenter extends Model
{
    use SoftDeletes;
    protected $table = 'entrepot_basic';
    protected $dates = [
        'deleted_at'
    ];
    protected $fillable=[
        'name',
        'eng_name',
        'contact',
        'contact_phone',
        'address',
        'comment',
        'area_province_id',
        'area_city_id',
        'area_district_id',
        'area_province_name',
        'area_city_name',
        'area_district_name',
        'fixed_telephone',];
    protected $hidden = ['created_at', 'updated_at','deleted_at'];

}
