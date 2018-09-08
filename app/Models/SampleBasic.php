<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SampleBasic extends Model
{
    use SoftDeletes;
    const CHECK_PASS = 1;//审核通过
    const CHECK_FAIL = 2;//审核不通过
    protected $table = 'sample_basic';
    protected $dates = [
        'deleted_at'
    ];
    protected $hidden = ['deleted_at'];
    protected $fillable = [
        'check_status',
				'applicant',
				'operator',
				'use_remark',
				'check_remark',
				'app_time',
				'check_time'
    ];

        /**
     * 审核状态
     * 索引
     * @var array
     */
    private static $status = [
        "待审核",
        "审核通过",
        "审核未通过"
    ];

    /**
     * 关联的商品
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function goods()
    {
        return $this->hasMany('App\Models\SampleGoods', 'sample_id');
    }


}
