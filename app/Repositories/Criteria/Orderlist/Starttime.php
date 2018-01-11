<?php
namespace App\Repositories\Criteria\Orderlist;

use Bosnadev\Repositories\Contracts\RepositoryInterface as Repository;
use Bosnadev\Repositories\Criteria\Criteria;

class Starttime extends Criteria
{
    /**
     *  @var string
     */
    private $start_time = null;

    public function  __construct($start_time)
    {
        $this->start_time = $start_time;
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
        $query = $model->where('order_time','>=', $this->start_time);
        return $query;
    }
}