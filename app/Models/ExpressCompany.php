<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExpressCompany extends Model
{
    //
    use SoftDeletes;
    protected $table ='express_companies';
    protected $fillable=[
      'entrepot_id',
      'entrepot_name',
      'company_name',
      'contact_name',
      'contact_tel',
      'remark',
      'eng'
    ];
    protected $hidden = ['created_at', 'updated_at','deleted_at'];
    protected $dates = [
        'deleted_at'
    ];
}
