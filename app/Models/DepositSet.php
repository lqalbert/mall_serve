<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DepositSet extends Model
{
    use SoftDeletes;
    
    protected $table = 'deposit_set';
    
    protected $dates = [
        'deleted_at'
    ];
    
    protected $fillable = [
        'type',
        'appendage_rate',
        'sale_rate',
        'return_rate'
    ];
    
    public static function getInstance()
    {
        return self::find(1);
    }
    
    
    public function getTypeTextAttribute()
    {
        //0即时返还 1发货时返还 2签收时返还
        $map = ['即时返还','发货时返还', '签收时返还'];
        return $map[$this->type];
    }
    
    public function getAppendage()
    {
        return $this->appendage_rate / 100;
    }
    
    public function getSale()
    {
        return $this->sale_rate / 100;
    }
    
    public function getReturn()
    {
        return $this->return_rate / 100;
    }
    
    // 即时返还
    public function isZero()
    {
        return $this->type == 0;
    }
    
    // 发货时返还
    public function isOne()
    {
        return $this->type == 1;
    }
    
    // 签收时返还
    public function isTwo()
    {
        return $this->type == 2;
    }
}
