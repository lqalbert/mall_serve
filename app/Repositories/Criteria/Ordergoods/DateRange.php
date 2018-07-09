<?php
namespace App\Repositories\Criteria\Ordergoods;

use Bosnadev\Repositories\Contracts\RepositoryInterface as Repository;
use Bosnadev\Repositories\Criteria\Criteria;

class DateRange extends Criteria
{
    /**
     *  @var string
     */
    private $range = null;
    
    public function  __construct($range, $field="created_at")
    {
        $this->range= $range;
        $this->field = $field;
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
        
        $range = $this->range;
        $model->where([
            [$this->field, '>=', $range[0]],
            [$this->field, '<=', $range[1]],
        ]);
        return $model;
    }
}