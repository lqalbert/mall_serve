<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExpressCompensation extends Model
{
    use SoftDeletes;

    protected $table = 'express_compensations';


    protected $dates = [
        'deleted_at'
    ];
    protected $hidden = ['created_at', 'updated_at','deleted_at'];

    protected $fillable = [
        'entrepot_id',
        'express_id',
        'entrepot_name',
        'express_name',
        'deliver_time',
        'order_number',
        'express_number',
        'compensation_type',
        'compensation_money',
        'processing_progress',
        'remark',

    ];
}
