<?php

namespace App\Models;

use Zizaco\Entrust\EntrustRole;
use Illuminate\Database\Eloquent\Builder;

/**
 * @var string name 角色的唯一名称，如"admin","owner"
 * @var string display_name 人类可读的角色名
 * @var string description 角色详细描述 
 * @author hyf
 *
 */
class Role extends EntrustRole
{
    //
    
    public static function boot()
    {
        parent::boot();
        
        static::addGlobalScope('hide', function(Builder $builder){
            $builder->where('hidden', 0);
        });
    }
}
