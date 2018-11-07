<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DepositDetail extends Model
{
    use SoftDeletes;
    
    const TYPE_ONE = 1;
    const TYPE_TWO = 2;
    
    
    protected $table = 'deposit_detail';
    
    protected $dates = [
        'deleted_at'
    ];
    
    protected $fillable = [
        'order_id',
        'type',
        'amount',
        'deposit',
        'saler_point',
        'entrepot_point',
        'thirdpart_point',
        'freight',
        'return_deposit'
    ];
    
    public function getTypeTextAttribute()
    {
        $map = ['','商品','赠品'];
        return $map[$this->type];
    }
}
