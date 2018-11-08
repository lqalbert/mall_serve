<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderType extends Model
{
    const INNER_NAME = '内部订单';
    const SALE_NAME  = '销售订单';
    use SoftDeletes;
    
    protected $table = 'order_type';
    
    protected $dates = ['deleted_at'];
    
    protected $fillable = [
        'name',
        'is_include',
        'discount',
        'status'
    ];
    
    public function getIsIncludeTextAttribute()
    {
        $map = ['不包','包邮'];
        return $map[$this->is_include];
    }
    
    public function getStatusTextAttribute()
    {
        $map=['禁用','启用'];
        return $map[$this->status];
    }
    
    public function getDiscounted($money)
    {
        return $this->discount * $money / 100;
    }
    
    public function toPlan()
    {
        $tmp = new \stdClass;
        $tmp->name = $this->name;
        $tmp->is_include = $this->is_include;
        $tmp->discount = $this->discount;
        return $tmp;
    }
    //人工判断一下是不是内购订单
    public function isInner()
    {
        return $this->name == self::INNER_NAME;
    }
}
