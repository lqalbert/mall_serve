<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    protected $table="user_basic";


    protected $dates = [
        'deleted_at'
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'head',
        'account',
        'password',
        'role_id',
        'group_id',
        'department_id',
        'department_name',
        'group_name',
        'sex',
        'telephone',
        'mobile_phone',
        'realname',
        'address',
        'qq',
        'qq_nickname',
        'weixin',
        'weixin_nickname',
        'role_name',
        'id_card',
        'ip',
        'create_name',
        'location',

    ];
    protected $appends = [
        'lg_time',
        'out_time',
        'role'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    public function getLgTimeAttribute()
    {
        return '2018-01-11';
    }
    public function getOutTimeAttribute()
    {
        return '2018-01-11';
    }
    public function getRoleAttribute()
    {
        return '普通';
    }
    public function  getHeadAttribute($value) 
    {
        return asset($value);
    }
}
