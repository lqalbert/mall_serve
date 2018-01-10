<?php
namespace App\Repositories\Criteria\Orderlist;

use Bosnadev\Repositories\Contracts\RepositoryInterface as Repository;
use Bosnadev\Repositories\Criteria\Criteria;

class Goodsname extends Criteria
{
    /**
     *  @var string
     */
    private $goods_name = null;

    public function  __construct($goods_name)
    {
        $this->goods_name = $goods_name;
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
        $query = $model->where('goods_name','like',$this->goods_name."%");
        return $query;
    }
}