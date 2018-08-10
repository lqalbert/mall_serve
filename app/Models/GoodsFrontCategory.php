<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoodsFrontCategory extends Model
{
    protected $table = "front_goods";
    
    protected $fillable = [
      'goods_id',
      'front_id'
    ];
}
