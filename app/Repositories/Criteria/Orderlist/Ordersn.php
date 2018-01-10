<?php
namespace App\Repositories\Criteria\Orderlist;

use Bosnadev\Repositories\Contracts\RepositoryInterface as Repository;
use Bosnadev\Repositories\Criteria\Criteria;

class Ordersn extends Criteria
{
    /**
     *  @var string
     */
    private $order_sn = null;

    public function  __construct($order_sn)
    {
        $this->order_sn = $order_sn;
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
        $query = $model->where('order_sn',$this->order_sn);
        return $query;
    }
}