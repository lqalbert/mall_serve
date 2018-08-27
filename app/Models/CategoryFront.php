<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryFront extends Model
{
    use SoftDeletes;
    protected $table = 'category_front';
    protected $fillable = [
        'label',
        'pid'
    ];
    
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function goods()
    {
        return $this->belongsToMany('App\Models\Goods', 'front_goods', 'front_id', 'goods_id');
    }
}
