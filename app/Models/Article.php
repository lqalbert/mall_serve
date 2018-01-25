<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use SoftDeletes;
    
	protected $table = 'article_basic';
	
	protected $dates = [
			'delete_at'
	];
	
	protected $fillable = [
			'title',
			'slug',
			'body',
			'imag',
			'user_id'
	];
	
	public function getDescriptionAttribute(){
		return mb_substr(strip_tags($this->attributes['body']),0, 100);
	}
}
