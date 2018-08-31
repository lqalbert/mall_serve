<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SampleGoods extends Model
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







}
