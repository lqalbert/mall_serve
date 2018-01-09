<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Orderlist extends Model
{
    //
    use SoftDeletes;
    protected $table = 'orderlist';
    /**
     * 需要被转换成日期的属性。 softdelete 需要
     *
     * @var array
     */
    protected $dates = [
        'deleted_at'
    ];
    /**
     * 可以被批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = [
        'order_sn',
        'order_type',
        'o_shop',
        'goods_name',
        'order_status'
    ];
    /**
     * 在数组中想要隐藏的属性。
     *
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at','deleted_at'];

    protected $appends = [
        'user',
        'phone',
        'order_type'

    ];
    private static $types = array(
        '销售部',
        '推广部',
        '客服部',
        '投顾部',
        '风控部'
    );
    public static function getType($index = null)
    {
        if ($index === null) {
            return self::$types;
        } else
            if (is_numeric($index) && in_array(intval($index), array_keys(self::$types))) {
                return self::$types[$index];
            }
        return self::$types[0];
    }
    /**
     * 获得联系人姓名
     */
    public function getUserAttribute()
    {
        return '未实现';
    }
    /**
     * 获得联系人电话
     */
    public function getPhoneAttribute()
    {
        return '80808501';
    }
    public function getOrderTypeAttribute()
    {
        return '1';
    }
}
