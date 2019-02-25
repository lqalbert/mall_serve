<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Efficacy extends Model
{
	    use SoftDeletes;
	    
		protected $table = 'efficacy';
		
		protected $dates = [
				'delete_at'
		];
		
		protected $fillable = [
				'plan_id',
				'name',
				'key_words',
				'situation',
				'suggestion',
				'creator_id',
		];

    public function user()
    {
        return $this->belongsTo('App\Models\User','creator_id','id')->select(['id','realname']);
    }

    public function combinationGoods()
    {
        return $this->belongsTo('App\Models\combinationGoods','plan_id','plan_id')->select(['type','name','number']);
    }
}
