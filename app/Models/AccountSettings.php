<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccountSettings extends Model
{
    use SoftDeletes;
    protected $table = 'account_settings';
    protected $dates = [
        'deleted_at'
    ];
    protected $hidden = ['created_at', 'updated_at','deleted_at'];
    protected $fillable = [
        'user_id',
        'department_id',
        'group_id',
        'department_name',
        'group_name',
        'user_name',
        'remark',
        'now_number',
        'max_number',
        'status',
    ];
}
