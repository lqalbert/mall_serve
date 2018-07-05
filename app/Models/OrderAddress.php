<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @var string area_city_name
 * @author hyf
 *
 */
class OrderAddress extends Model
{
    use SoftDeletes;
    protected $table = 'order_address';
    protected $dates = [
        'deleted_at'
    ];
    protected $hidden = ['created_at', 'updated_at','deleted_at'];
    protected $fillable = [
        'order_id',
        'cus_id',
        'name',
        'phone',
        'zip_code',
        'address',
        'default_address',
        'area_province_name',
        'area_city_name',
        'area_district_name',
        'area_province_id',
        'area_city_id',
        'area_district_id',
        'fixed_telephone',
    ];

    
    
    /**
     * 获取菜鸟接口规定的收货地址结构数据
     */
    public function getRecipient()
    {
        //         'recipient'=>[
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
                'province'=>$this->area_province_name,
                'city'    =>$this->area_city_name,
                'district'=>$this->area_district_name,
//                 'town'    =>"",
                'detail'  =>$this->address
            ],
            "phone"=>$this->fixed_telephone,
            "mobile"=>$this->phone,
            "name"=>$this->name
        ];
    }

    
}
