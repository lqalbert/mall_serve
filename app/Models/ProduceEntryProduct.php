<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProduceEntryProduct extends Model
{
    use SoftDeletes;
    
    protected $dates = [
        'deleted_at'
    ];
    
    protected $table = 'produce_in_product';
    
    protected $fillable = [
        
    ];
    
    public function produceEntry()
    {
        return $this->belongsTo('App\Models\ProduceEntry', 'parent_id');
    }
}
