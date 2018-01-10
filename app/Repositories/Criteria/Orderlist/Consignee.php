<?php
namespace App\Repositories\Criteria\Orderlist;

use Bosnadev\Repositories\Contracts\RepositoryInterface as Repository;
use Bosnadev\Repositories\Criteria\Criteria;

class Consignee extends Criteria
{
    /**
     *  @var string
     */
    private $consignee = null;

    public function  __construct($consignee)
    {
        $this->consignee = $consignee;
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
        $query = $model->where('consignee','like',$this->consignee."%");
        return $query;
    }
}