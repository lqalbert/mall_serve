<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GoodsCombo extends Model
{
    use SoftDeletes;
    
    protected $table = 'goods_combo';
    
    protected $fillable = [
        'combo_id',
        'goods_id',
        'name',
        'price',
        'num'
    ];
    
    public function goods()
    {
        return $this->belongsTo('App\Models\Goods', 'goods_id');
    }
}
