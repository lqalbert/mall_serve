<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerUser extends Model
{
    use SoftDeletes;
    
    protected $table = 'customer_user';
    
    protected $dates = [
    	'delete_at'
    ];
    
    protected $fillable = [
    	'user_id',
    	'cus_id',
    	'group_id',
    	'department_id'
    ];
    
    
}
