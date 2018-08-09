<?php
namespace App\Repositories\Criteria\Orderlist;

use Bosnadev\Repositories\Contracts\RepositoryInterface as Repository;
use Bosnadev\Repositories\Criteria\Criteria;

class AfterSale extends Criteria
{
    
    public function apply($model, Repository $repository)
    {
        return $model->has("afterSale");
    }
}