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
      'eng',
      'printer'
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
        $contact = $this->entrepot;
        return [
            'address'=>json_decode($this->send_address, true),
            "phone"=>$contact->fixed_telephone,
            "mobile"=>$contact->contact_phone,
            "name"=>$contact->contact
        ];
    }
    
    /**
     * 获取菜鸟的模板url
     */
    public function getTemplateUrl()
    {
        return  env('APP_ENV') == 'production' ? config('cainiao.print_template.'.$this->eng) : "http://cloudprint.daily.taobao.net/template/standard/137411/1";
    }
    
    public function setSendAddressAttribute($value)
    {
        return $this->attributes['send_address'] = json_encode($value);
    }
    
    public function entrepot()
    {
        return $this->belongsTo('App\Models\DistributionCenter');
    }
    
    
}
