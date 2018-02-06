<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerUser extends Model
{
    use SoftDeletes;
    
    const ADD = 0;
    const TRANSFER = 1;
    const QUIT = 2;
    
    protected $table = 'customer_user';
    
    protected $dates = [
    	'delete_at'
    ];
    
    protected $fillable = [
    	'user_id',
    	'cus_id',
    	'type',
    	'group_id',
    	'department_id'
    ];
    
    private static $type = [
    		'创建', //0
    		'转让', //1
    		'离职'  //2
    ];
    
    public function getTypeTextAttribute(){
    	return self::$type[$this->attributes['type']];
    }
    
    
}
