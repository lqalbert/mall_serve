<?php
namespace App\Repositories\Criteria\Orderlist;

use Bosnadev\Repositories\Contracts\RepositoryInterface as Repository;
use Bosnadev\Repositories\Criteria\Criteria;

class OrderStatus extends Criteria
{
    /**
     *  @var string
     */
    private $order_status = null;

    public function  __construct($status)
    {
        $this->order_status = $status;
       // var_dump($status);die;
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
        $query = $model->where('order_status', $this->order_status);
        return $query;
    }
}