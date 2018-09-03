<?php
namespace App\Repositories\Criteria\Assign;

use Bosnadev\Repositories\Contracts\RepositoryInterface;
use Bosnadev\Repositories\Criteria\Criteria;
use Illuminate\Http\Request;

class PrintStatus extends Criteria
{
    private $request= null;
    
    
    
    public function __construct()
    {
        
        
    }
    
    
    public function  apply($model, RepositoryInterface $repository)
    {
        return $model->where(function($query){
            $query->where('assign_print_status','=',1)->orWhere('express_print_status','=',1);
        });
    }
}