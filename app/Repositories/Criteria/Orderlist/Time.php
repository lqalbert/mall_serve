<?php
namespace App\Repositories\Criteria\Department;

use Bosnadev\Repositories\Criteria\Criteria;
use Bosnadev\Repositories\Contracts\RepositoryInterface;

class Time extends Criteria
{
    /**
     * @var string
     */
    private $time = null;

    public function  __construct($time)
    {
        $this->time = $time;
    }


    public function  apply($model, RepositoryInterface $repository)
    {
        if (is_array($this->type)) {
            return $model->whereIn('type', $this->type);
        }
        return $model->where('type', $this->type);
    }
}