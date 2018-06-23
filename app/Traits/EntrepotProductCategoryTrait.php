<?php
namespace App\traits;


trait EntrepotProductCategoryTrait
{
    public function category()
    {
        return $this->belongsTo('App\Models\EntrepotProductCategory', 'sku_sn');
    }
}