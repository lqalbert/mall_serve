<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExpressCompany extends Model
{
    //
    use SoftDeletes;
    protected $table ='express_companies';
    protected $fillable=[
      'entrepot_id',
      'entrepot_name',
      'company_name',
      'contact_name',
      'contact_tel',
      'remark',
      'eng'
    ];
    protected $hidden = ['created_at', 'updated_at','deleted_at'];
    protected $dates = [
        'deleted_at'
    ];
    
    
    /**
     * 获取菜鸟接口规定的发货地址结构数据
     */
    public function getSend()
    {
//         'sender'=>[
//             'address'=>[
//                 'province'=>"",
//                 'city'    =>"",
//                 'district'=>"",
//                 'town'    =>"",
//                 'detail'  =>""
//             ],
//             "phone"=>"",
//             "mobile"=>"",
//             "name"=>""
//         ]
        return [
            'address'=>[
                'province'=>"",
                'city'    =>"",
                'district'=>"",
                'town'    =>"",
                'detail'  =>""
            ],
            "phone"=>"",
            "mobile"=>"",
            "name"=>""
        ];
    }
    
    /**
     * 获取菜鸟的模板url
     */
    public function getTemplateUrl()
    {
       return config('cainiao.'.$this->attributes['eng']);
    }
}
