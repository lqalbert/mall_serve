<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SlideManage extends Model
{
    use SoftDeletes;

    protected $table= 'slide_manages';

    protected $dates=[
        'deleted_at'
    ];

    /**
     * 可以被批量赋值的属性
     */
    protected $fillable = [
        'classify'
    ];

    protected  $hidden = ['updated_at', 'deleted_at','created_at'];

}
