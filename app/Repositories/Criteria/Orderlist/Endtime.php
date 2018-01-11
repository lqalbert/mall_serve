<?php
namespace App\Repositories\Criteria\Orderlist;

use Bosnadev\Repositories\Contracts\RepositoryInterface as Repository;
use Bosnadev\Repositories\Criteria\Criteria;

class Endtime extends Criteria
{
    /**
     *  @var string
     */
    private $end_time = null;

    public function  __construct($end_time)
    {
        $this->end_time = $end_time;
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
        $query = $model->where('order_time','<=', $this->end_time);
        return $query;
    }
}