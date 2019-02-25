<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PersonalCare extends Model
{
	    use SoftDeletes;
	    
		protected $table = 'personal_care';
		
		protected $dates = [
				'delete_at'
		];
		
		protected $fillable = [
				'plan_num',
				'user_id',
				'user_name',
				'user_sex',
				'diagnosis',
				'deal_plan',
				'sign',
				'sum',
				'introduction',
				'organization',
				'show'
		];

    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id','id')->select(['id','realname','sex']);
    }

}
