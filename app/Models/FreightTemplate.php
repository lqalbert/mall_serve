<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Scopes\IdDesc;

class FreightTemplate extends Model
{
//     use SoftDeletes;
    protected $table = 'freight_template';
    protected $fillable = [
        'name',
        'express',
        'entrepot_id',
        'is_unify',
        'unify_fee',
        'is_include',
        'stand_fee',
        'stand_extra',
        'basic_fee'
    ];
    
    protected $hidden = ['created_at', 'updated_at'];
    
//     protected $dates = [
//         'deleted_at'
//     ];
    
    protected static function boot()
    {
        parent::boot();
        
        static::addGlobalScope(new IdDesc());
    }
}
