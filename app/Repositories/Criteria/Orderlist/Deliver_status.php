<?php
namespace App\Repositories\Criteria\Orderlist;

use Bosnadev\Repositories\Contracts\RepositoryInterface as Repository;
use Bosnadev\Repositories\Criteria\Criteria;

class Deliver_status extends Criteria
{
    /**
     *  @var string
     */
    private $status = null;

    public function  __construct($status)
    {
        $this->status = $status;
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
        $query = $model->where('shipping_status',$this->status);
        return $query;
    }
}