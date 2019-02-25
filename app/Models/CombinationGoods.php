<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CombinationGoods extends Model
{
	    use SoftDeletes;
	    
		protected $table = 'combination_goods';
		
		protected $dates = [
				'delete_at'
		];
		
		protected $fillable = [
				'plan_id',
				'type',
				'name',
				'number'
		];

        public function goods()
        {
            return $this->hasOne('App\Models\Goods','id','name');
        }

}
