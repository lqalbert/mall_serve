<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
class Orderlist extends Model
{
    //
    use SoftDeletes;
    protected $table = 'order_basic';
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
        'order_status',
        'o_shop',
        'goods_name',
        'cus_id',
        'cus_name',
        'deal_id'
    ];
    protected $appends = [
        'cus_name',
        'user_name',
    ];
    /**
     * 对象 转 数组
     *
     * @param object $obj 对象
     * @return array
     */
    function object_to_array($obj) {
        $obj = (array)$obj;
        foreach ($obj as $k => $v) {
            if (gettype($v) == 'resource') {
                return;
            }
            if (gettype($v) == 'object' || gettype($v) == 'array') {
                $obj[$k] = (array)$this->object_to_array($v);
            }
        }

        return $obj;
    }
    /** 索引数组转化成关联数组 */
    function toIndexArr($arr){
        $i=0;
        foreach($arr as $key => $value){
            $newArr[$i] = $value;
            $i++;
    }
        return $newArr;
    }
    /**
     * 根据用户id获取用户姓名
     *
     */
    public function get_cusinfo(){
        $customer = DB::table('customer_basic')->select('name', 'id')->get();
        $newarray = array();
        $customer = $this->toIndexArr($this->object_to_array($customer));
        foreach ($customer[0] as $v)
        {
            $id = $v['id'];
            $name = $v['name'];
            $newarray[$id] = $name;
        }
        return $newarray;
    }
    /**
     * 根据员工id获取员工姓名
     *
     */
    public function get_employeeinfo(){
        $employee = DB::table('user_basic')->select('realname', 'id')->get();
        $newarray = array();
        $employee = $this->toIndexArr($this->object_to_array($employee));
        foreach ($employee[0] as $v)
        {
            $id = $v['id'];
            $name = $v['realname'];
            $newarray[$id] = $name;
        }
        return $newarray;
    }
    public static function getType($index = null,$types)
    {
        if ($index === null) {
            return $types;
        } else
            if ($index && in_array($index, array_keys($types))) {
                return $types[$index];
            }
        return $types;
    }
    /*
     * 获取客户的姓名
     */
    public function getCusNameAttribute()
    {
        return self::getType($this->attributes['cus_id'],$this->get_cusinfo());
    }
    /*
     * 获取员工的姓名
     */
    public function getUserNameAttribute()
    {
        return self::getType($this->attributes['deal_id'],$this->get_employeeinfo());
    }
    /**
     * 在数组中想要隐藏的属性。
     *
     * @var array
     */
    protected $hidden = ['updated_at','deleted_at'];

}
