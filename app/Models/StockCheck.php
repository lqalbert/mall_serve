<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockCheck extends Model
{
    protected $table = 'inventory_check';
    
    protected $fillable = [
        'check_num',
		'check_name',
		'check_user_id',
    ];


	public function goods()
    {
        return $this->hasMany('App\Models\StockCheckGoods', 'check_id');
    }





}
