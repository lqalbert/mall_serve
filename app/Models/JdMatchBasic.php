<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JdMatchBasic extends Model
{
    use SoftDeletes;

    protected $table = 'jd_match_basic';

    protected $dates = ['deleted_at'];

    protected $hidden = [ 'updated_at','deleted_at'];

    protected $fillable = [
    	'flag',
    	'sum',
    	'match_status',
    	'file_name',
        'inventory_status'
    ];






}
