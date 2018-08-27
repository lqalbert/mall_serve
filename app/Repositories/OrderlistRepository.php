<?php
namespace App\Repositories;

use Bosnadev\Repositories\Eloquent\Repository;

class OrderlistRepository extends Repository
{
    
    protected $preventCriteriaOverwriting = false;
    public function  model()
    {
//         return 'App\Models\Orderlist';
        return 'App\Models\OrderBasic';
    }
    public static function  setVisible($collection, $attributes)
    {
        foreach ($collection as &$model) {
            $model->setAppends($attributes);
        }
        return $collection;
    }
}
