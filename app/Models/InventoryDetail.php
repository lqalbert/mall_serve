<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InventoryDetail extends Model
{
   
    
    protected $table = 'inventory_detail';
    
    /**
     * 需要被转换成日期的属性。 softdelete 需要
     *
     * @var array
     */
    protected $dates = [
//         'deleted_at'
    ];
    
    protected $guarded = [
    ];
    
    
}
