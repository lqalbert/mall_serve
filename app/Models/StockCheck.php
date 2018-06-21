<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockCheck extends Model
{
    protected $table = 'inventory_check';
    
    protected $fillable = [
        'check_sn',
		'check_name',
		'check_user_id',
        'remark',
        'check_status',
        'entrepot_id',
        'entrepot_name',
    ];


	public function goods()
    {
        return $this->hasMany('App\Models\StockCheckGoods', 'check_id');
    }





}
