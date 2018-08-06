<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mail extends Model
{
    use SoftDeletes;
    protected $table="mails";
    protected $hidden = [
        'password',
        'updated_at',
        'deleted_at'
    ];
    protected $dates = [
        'deleted_at'
    ];
    protected $fillable = [
        'name',
        'phone',
        'express_id',
        'express_name',
        'express_sn',
        'area_province_id',
        'area_city_id',
        'area_district_id',
        'area_province_name',
        'area_city_name',
        'area_district_name',
        'address',
        'remark',
        'type',
    ];
    
    public function entrepot()
    {
        return $this->belongsTo('App\Models\DistributionCenter');
    }
    
    public function express()
    {
        return $this->belongsTo('App\Models\ExpressCompany');
    }
    
    public function address()
    {
//         return $this->belongsTo('App\Models\OrderAddress', 'address_id');
    }
    
    public function goods()
    {
        return $this->hasMany('App\Models\MailGoods','mail_id');
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
    
//     public function getRecipient()
//     {
        
//     }
    
    /**
     * 获取菜鸟接口规定的收货地址结构数据
     */
    public function getRecipient()
    {

        return [
            'address'=>[
                'province'=>$this->area_province_name,
                'city'    =>$this->area_city_name,
                'district'=>$this->area_district_name,
                //                 'town'    =>"",
                'detail'  =>$this->address
            ],
            "phone"=>$this->phone,
            "mobile"=>"",
            "name"=>$this->name
        ];
    }
}
