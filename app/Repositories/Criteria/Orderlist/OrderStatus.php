<?php
namespace App\Repositories\Criteria\Orderlist;

use Bosnadev\Repositories\Contracts\RepositoryInterface as Repository;
use Bosnadev\Repositories\Criteria\Criteria;

class OrderStatus extends Criteria
{
    /**
     *  @var string
     */
    private $where = null;

    public function  __construct($where)
    {
        $this->where = $where;
    }

    /**
     *
     * @param unknown $model
     * @param Repository $repository
     *
     * @return mixed
     */
    public function  apply($model, Repository $repository)
    {
        $query = $model->where($this->where);
        return $query;
    }
}