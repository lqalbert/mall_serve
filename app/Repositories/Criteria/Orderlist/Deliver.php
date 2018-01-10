<?php
namespace App\Repositories\Criteria\Orderlist;

use Bosnadev\Repositories\Contracts\RepositoryInterface as Repository;
use Bosnadev\Repositories\Criteria\Criteria;

class Deliver extends Criteria
{
    /**
     *  @var string
     */
    private $deliver = null;

    public function  __construct($deliver)
    {
        $this->deliver = $deliver;
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
        $query = $model->where('shipping_status', $this->deliver);
        return $query;
    }
}