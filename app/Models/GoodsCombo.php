<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Contracts\Goods as GoodsContracts;

class GoodsCombo extends Model implements GoodsContracts
{
    use SoftDeletes;
    
    protected $table = 'goods_combo';
    
    protected $dates = ['deleted_at'];
    
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
    
    public function getSkuSn()
    {
        return $this->goods->sku_sn;
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function getNum()
    {
        return $this->num;
    }
}
