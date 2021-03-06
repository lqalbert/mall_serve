<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use App\Events\AssignCreating;
use Carbon\Carbon;
use App\Events\AssignCreated;
use App\Models\Scopes\IdDesc;

class Assign extends Model
{
    use SoftDeletes;
    const STATUS_DONE = 1;
    const STATUS_CHECKEDGOODS = 4;
    const STATUS_WEIGHTGOODS = 3;
    const STATUS_PARCEL = 5;
    const STATUS_SIGNATURE = 6;
    
    protected $table = 'assign_basic';
    
    
    /**
     * 需要被转换成日期的属性。 softdelete 需要
     *
     * @var array
     */
    protected $dates = [
        'deleted_at'
    ];
    //前端　查询那里是写死了的　这里修改了　前端还要再改一下
    private static $statusMap = [
        '未审核',
        '已审核',
        '审核未通过',
        '已发货',
        '已验货',
        '已揽件',
       // '已拦截',  另一个字段 is_stop
        //'已打印', 
        '已签收'
    ];
    
    protected $hidden = ['print_data'];
    
//     protected $fillable = [
//         'entrepot_id',
//         'assign_sn',
//         'order_id',
//         'user_id',
//         'user_name',
//         'status',
//         'express_id',
//         'express_name',
//         'assign_print_status',
//         'express_print_status',
//         'set_express',
//         'express_print_at',
//         'assign_print_at',
//         'weight',
//         'assign_fee',
//         'express_fee',
//         'out_entrepot-at',
//         'sign_at'
//     ];
    
    /**
     * 黑名单
     * @var array
     */
    protected $guarded = [];
    
    protected $events = [
//       'creating'=> AssignCreating::class  ,
      'created'=> AssignCreated::class  
    ];
    
    public function entrepot()
    {
        return $this->belongsTo('App\Models\DistributionCenter');
    }
    
    public function order()
    {
        return $this->belongsTo('App\Models\OrderBasic', 'order_id');
    }
    
    public function getStatusTextAttribute()
    {
        return self::$statusMap[$this->attributes['status']];
    }
    
    public function address()
    {
        return $this->belongsTo('App\Models\OrderAddress', 'address_id');
    }
    
    public function goods()
    {
        return $this->hasMany('App\Models\OrderGoods','assign_id')->orderBy('sku_sn','asc');
    }
    
    public function express()
    {
        return $this->belongsTo('App\Models\ExpressCompany');    
    }
    
    
    /**
     * 返回菜鸟接口要求的结构化的数据
     * @return unknown
     */
    public function getPackageInfo()
    {
        $goods = $this->goods;
        $items = [];
        foreach ($goods  as $item ){
            $items[] = ['count'=> $item->goods_number, 'name'=>$item->goods_name];
        }
        return [
            'id'=>$this->attributes['id'],
            "items"=>$items,
           // "volume"=>"", //体积　非必填
           // "weight"=>"", //重量　非必填
        ];
    }
    
    public function isSetExpress()
    {
        return $this->attributes['set_express'] == null ? false : true;
    }
    
    /**
     * 是不是 处理 已揽件
     */
    public function isParcel()
    {
        return $this->status == self::STATUS_PARCEL;
    }
    
    /**
     * 处理 已发货 这里处理有点问题
     * 以前称重发货 已处理减库存了，
     *  在揽件那里又减库存，就会重复减库存。 现在没有揽件
     * 
     * 所以不再处理 已揽件 
     */
    public function isSended()
    {
        return $this->status == self::STATUS_WEIGHTGOODS;
    }
    
    public function isSignature()
    {
        return $this->status == self::STATUS_SIGNATURE;
    }
    
    public function updateWaybillPrintStatus()
    {
        $this->express_print_status = 1;
        $this->express_print_at = Carbon::now();
    }
    
    public function updateAssignPrintStatus()
    {
        $this->assign_print_status= 1;
        $this->assign_print_at= Carbon::now();
    }
    
    public function checkedGoods(User $user)
    {
        $this->status = self::STATUS_CHECKEDGOODS;
        $this->user_id = $user->id;
        $this->user_name = $user->realname;    
    }
    
    public function weightGoods($weight,$express_fee,User $user)
    {
        $this->status = self::STATUS_WEIGHTGOODS;
        $this->real_weigth = $weight;
        $this->express_fee = $express_fee;
//         $this->user_id = $user->id;
//         $this->user_name = $user->realname;
    }
    
    public function getPrintDataAttribute($value)
    {
        return json_decode($value, true);
    }
    
    public function updateParcelStatus()
    {
        $this->status = self::STATUS_PARCEL;// 已揽件
    }
    
    /**
     * 保持名称上的统一
     */
    public function updateSignStatus()
    {
        $this->status = self::STATUS_SIGNATURE;
        $this->sign_at = Carbon::now();
    }
    
    
    /**
     * 已发货作用域
     * @param unknown $query
     * @return unknown
     */
    public function scopeSended($query)
    {
        return $query->where('status', '=', self::STATUS_WEIGHTGOODS);
    }
    //getNameAttribute
    public function getNameAttribute()
    {
        return "[". $this->goods_number ."]" . "个  ". $this->sku_sn . "  " . $this->goods_name . "  " . $this->specifications;
    }
    
    
    /**
     * 获取配货单数量
     * 注意要在事务里面使用
     * @static
     *
     * @param int $entrepot_id
     *
     * @return integer
     */
    public static function getAssignCount($entrepot_id)
    {
        return self::withTrashed()->where('entrepot_id', $entrepot_id)
        ->lockForUpdate()->count();
    }
    
    
    protected static function boot()
    {
        parent::boot();
        
        static::addGlobalScope(new IdDesc());
    }
}
