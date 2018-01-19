<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GoodsImg extends Model
{
    use SoftDeletes;
    
    protected $table="goods_imgs";

	  protected $fillable = [
					'goods_id',
					'url',
	  ];
}
