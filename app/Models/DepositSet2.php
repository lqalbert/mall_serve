<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Events\SyncDiscount;

class DepositSet2 extends Model
{
//     use SoftDeletes;
    
    protected $table = 'deposit_set2';
    
    protected $dates = [
        'deleted_at'
    ];
    
    protected $fillable = [
        'type',
        'yk',
        'yz',
        'c',
        'zn',
        'j',
        'y',
        'n'
    ];
    
    protected $events = [
        'updated' => SyncDiscount::class
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
    
    public function getYk()
    {
        return $this->yk / 100;
    }
    
    public function getYz()
    {
        return $this->yz / 100;
    }
    
    public function getC()
    {
        return $this->c / 100;
    }
    
    public function getZn()
    {
        return $this->zn / 100;
    }
    
    public function getJ()
    {
        return $this->j / 100;
    }
    
    public function getY()
    {
        return $this->y / 100;
    }
    
    public function getN()
    {
        return $this->n / 100;
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
