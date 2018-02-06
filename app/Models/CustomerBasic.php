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
  

   
   
    
 
    
    public function  contacts() 
    {
        return $this->hasMany('App\Models\CustomerContact', 'cus_id');
    }
}
