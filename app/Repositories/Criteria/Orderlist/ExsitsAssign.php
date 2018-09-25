<?php
namespace App\Repositories\Criteria\Orderlist;

use Bosnadev\Repositories\Contracts\RepositoryInterface as Repository;
use Bosnadev\Repositories\Criteria\Criteria;

class ExsitsAssign extends Criteria
{
    
    public function apply($model, Repository $repository)
    {
        return $model->whereHas("assign", function($query) {
            return $query->where('is_repeat','<>',3);
        });
    }
}