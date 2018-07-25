<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GoodsType extends Model
{
    use SoftDeletes;
    
    protected $table = 'goods_type';
    
    protected $dates =[
    		'delete_at'
    ];
    
    protected $fillable = [
    		'name'
    ];
    
    
    public function specs(){
    	return $this->belongsToMany('App\Models\GoodsSpecs', 'spec_type', 'type_id', 'spec_id');
    }
    
    public function cate()
    {
        return $this->hasOne('App\Models\Category','type_id')->where('level',1)->select('id','label');
    }
}
