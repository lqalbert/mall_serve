<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\IdDesc;

class FreightExtra extends Model
{
    protected $table = 'freight_extra';
    protected $fillable = [
        'fee',
        'province_id',
        'fr_id'
    ];
    
    protected $hidden = ['created_at', 'updated_at'];
    
    public function province()
    {
        return $this->belongsTo('App\Models\AreaInfo', 'province_id')->select('id','name');
    }
    
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new IdDesc());
    }
}
