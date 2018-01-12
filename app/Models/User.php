<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use App\Events\AddEmployee;
/**
 * @todo use 这里有方法同名的 冲突 Authenticatable 与  EntrustUserTrait 都有can
 * @author hyf
 *
 */
class User extends Authenticatable
{
    /**
     * 这将会建立User与Role之间的关联关系：
     * 在User模型中添加roles()、hasRole($name)、can($permission)
     * 以及ability($roles,$permissions,$options)方法
     */
    use Notifiable, SoftDeletes, EntrustUserTrait {
        EntrustUserTrait::restore insteadof SoftDeletes;
        
//         EntrustUserTrait::can as may;
//         Authorizable::can insteadof EntrustUserTrait;
    }
    
    use Notifiable;
    
    
    /**
     * 模型的事件映射
     * @var string
     */
    protected $event = [
        'created' => AddEmployee::class
    ];
    
    
    
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
        'mobilephone',
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
