<?php
namespace App\Alg;

use Illuminate\Database\Eloquent\Collection;

class ModelCollection {
    
    /**
     * 给Model添加不存在数据表里的字段
     * @param unknown $collection
     * @param unknown $attributes
     * @return unknown
     */
    public static function  setAppends(Collection  $collection, array $attributes)
    {
        foreach ($collection as &$model) {
            $model->setAppends($attributes);
        }
        return $collection;
    }
}