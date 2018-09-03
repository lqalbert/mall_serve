<?php
namespace App\Repositories\Criteria\Ordergoods;

use Bosnadev\Repositories\Contracts\RepositoryInterface as Repository;
use Bosnadev\Repositories\Criteria\Criteria;

class AfterCondition extends Criteria
{
    public function apply($model, Repository $repository)
    {
        return $model->after();
    }
}