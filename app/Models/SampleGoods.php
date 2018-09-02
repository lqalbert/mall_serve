<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Contracts\Goods as GoodsContracts;

class SampleGoods extends Model implements GoodsContracts
{
    use SoftDeletes;
    protected $table = 'sample_goods';
    protected $dates = [
        'deleted_at'
    ];
    protected $hidden = ['deleted_at'];
    protected $fillable = [
        'sample_id',
				'goods_id',
				'goods_name',
				'goods_number',
				'price',
				'sku_sn',
				'sku_id',
				'sku_name',
				'width',
				'height',
				'len',
				'barcode',
				'weight',
				'bubble_bag',
				'specifications',
				'unit_type',
				'remark'
    ];

    /**
     * 反向关联的样品模型
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sample()
    {
        return $this->belongsTo('App\Models\SampleBasic', 'sample_id');
    }
    
    public function getSkuSn()
    {
        return $this->attributes['sku_sn'] ;
    }
    public function getName(){
        return $this->attributes['goods_name'];
    }
    
    public function getNum()
    {
        return $this->attributes['goods_number'];
    }






}
