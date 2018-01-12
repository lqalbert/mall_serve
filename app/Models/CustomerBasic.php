<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerBasic extends Model
{
    use SoftDeletes;

    /**
     * 软删除需要设置这个
     * 需要被转换成日期的属性。
     *
     * @var array
     */
    protected $dates = [
        'deleted_at'
    ];

    protected $table = 'customer_basic';

    /**
     * 批量赋值白名单
     * 
     * @var array
     */
    protected $fillable = [
        'name',
        'sex',
        'age',
//        'source',
//        'property',
//        'province',
//        'city',
//        'creator',
//        'quality',
//        'proceeds',
//        'manner',
//        'vigour',
//        'question',
//        'profit',
//        'attritude',
//        'occupation',
//        'desire'
        
    ];
    protected $hidden = [
        "created_at",
        "updated_at",
        "deleted_at"
    ];
    private static $source = [
        "东方财富",
        "今日头条",
        "新浪财经",
        "企鹅QQ公众平台",
        "一点资讯",
        "搜狐",
        "微博",
        "百度",
        "同花顺",
        "和讯",
        "其他"
    ];
    
    //资金量
    private static $property = [
        "5W以下",
        "5W-10W",
        "10W-20W",
        "20W-50W",
        "50W以上"
    ];
    
//     客户质量
    private static $quality = [
        '普通',
        '优质'
    ];
    
//     股龄
    private static $age = [
        "1年",
        "2年",
        "3年",
        "4年",
        "5年",
        "6年",
        "7年",
        "8年",
        "9年",
        "10年",
        "10年以上"
    ];
    //近期收益
    private static $proceeds = [
        "大亏",
        "小亏",
        "持平",
        "小赚",
        "大赚",
    ];
    
//     投资风格
    private static $manner=[
        '短线',
        '中线',
        '长线'
    ];
//     看盘精力
    private static $vigour = [
       '经常看盘',
       '偶尔看盘',
       '不怎么看盘'
    ];
    
    //投资问题
    private static $question = [
        "不会判断大盘",
        "不会选股",
        "买卖点把握不好",
        "仓位控制不好"
    ];
    
    
    //态度
    private static $attitude = [
        '友好',
        '正常',
        '恶劣'
    ];
    
    //盈利模式
    private static $profit = [
        "无",
        "有，但不理想",
        "有"
    ];
    
    
    //职业
    private static $occupation = [
        "退休人员",
        "公务员",
        "医生",
        "教师",
        "个体老板",
        "学生",
        "职业股民",
        "公司职员",
        "警察",
        "国企职工"
    ];
    
    //意向
    private static $desire = [
        "主动了解",
        "愿意了解",
        "不排斥",
        "排斥"
    ];

    public static function getSource($index = null)
    {
        if ($index === null) {
            return self::$source;
        } else 
            if (is_numeric($index) && in_array(intval($index), array_keys(self::$source))) {
                return self::$source[$index];
            }
        return self::$source[0];
    }

    public static function getProperty($index = null)
    {
        if ($index === null) {
            return self::$property;
        } else 
            if (is_numeric($index) && in_array(intval($index), array_keys(self::$property))) {
                return self::$property[$index];
            }
        return self::$property[0];
    }
    
    public static function getQuality($index = null)
    {
        if ($index === null) {
            return self::$quality;
        } else
            if (is_numeric($index) && in_array(intval($index), array_keys(self::$quality))) {
                return self::$quality[$index];
            }
        return self::$quality[0];
    }
    
    //股龄
    public static function  getAge($index = null) 
    {
        if ($index === null) {
            return self::$age;
        } else
            if (is_numeric($index) && in_array(intval($index), array_keys(self::$age))) {
                return self::$age[$index];
            }
        return self::$age[0];
    }
    
    //近期收益
    public static function getProceeds($index = null)
    {
        if ($index === null) {
            return self::$proceeds;
        } else
            if (is_numeric($index) && in_array(intval($index), array_keys(self::$proceeds))) {
                return self::$proceeds[$index];
            }
        return self::$proceeds[0];
    }
    
    //投资风格
    public static function getManner($index = null)
    {
        if ($index === null) {
            return self::$manner;
        } else
            if (is_numeric($index) && in_array(intval($index), array_keys(self::$manner))) {
                return self::$manner[$index];
            }
        return self::$manner[0];
    }
    
    //看盘精力
    public static function getVigour($index = null)
    {
        if ($index === null) {
            return self::$vigour;
        } else
            if (is_numeric($index) && in_array(intval($index), array_keys(self::$vigour))) {
                return self::$vigour[$index];
            }
        return self::$vigour[0];
    }
    
    //看盘精力
    public static function getQuestion($index = null)
    {
        if ($index === null) {
            return self::$question;
        } else
            if (is_numeric($index) && in_array(intval($index), array_keys(self::$question))) {
                return self::$question[$index];
            }
        return self::$question[0];
    }
    
    public static function getAttitude($index = null)
    {
        if ($index === null) {
            return self::$attitude;
        } else
            if (is_numeric($index) && in_array(intval($index), array_keys(self::$attitude))) {
                return self::$attitude[$index];
            }
        return self::$attitude[0];
    }
    
    //盈利模式
    public static function getProfit($index = null)
    {
        if ($index === null) {
            return self::$profit;
        } else
            if (is_numeric($index) && in_array(intval($index), array_keys(self::$profit))) {
                return self::$profit[$index];
            }
        return self::$profit[0];
    }
    
    public static function getOccupation($index = null)
    {
        if ($index === null) {
            return self::$occupation;
        } else
            if (is_numeric($index) && in_array(intval($index), array_keys(self::$occupation))) {
                return self::$occupation[$index];
            }
        return self::$occupation[0];
    }
    
    //意向
    public static function getDesire($index = null)
    {
        if ($index === null) {
            return self::$desire;
        } else
            if (is_numeric($index) && in_array(intval($index), array_keys(self::$desire))) {
                return self::$desire[$index];
            }
        return self::$desire[0];
    }

    /**
     * creator 修改器
     * 
     * @return null
     */
    public function setCreatorAttribute($value)
    {
        $this->attributes['creator'] = $value;
    }
    
    /**
     * 获取应用业务表
     */
    public function app()
    {
        return $this->hasOne('App\Models\CustomerApp', 'cus_id');
    }
    
    public function  contacts() 
    {
        return $this->hasMany('App\Models\CustomerContact', 'cus_id');
    }
}
