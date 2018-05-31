<?php
namespace App\Repositories\Criteria\Assign;

use Bosnadev\Repositories\Contracts\RepositoryInterface;
use Bosnadev\Repositories\Criteria\Criteria;
use Illuminate\Http\Request;

class Address extends Criteria 
{
    private $request= null;
    

    
    public function __construct(Request $request)
    {
        
        $this->request = $request;
    }
    
    
    public function  apply($model, RepositoryInterface $repository)
    {
        $request = $this->request;
        $address = [
            'name',
            'phone',
            'area_province_id',
            'area_city_id'
        ];
        return $model->whereHas('address', function($query) use($request){
            if ($request->has('name')) {
                $query->where('name', $request->input('name'));
            }
            
            if ($request->has('phone')) {
                $query->where('phone', $request->input('phone'));
            }
            
            if ($request->has('area_province_id')) {
                $query->where('area_province_id', $request->input('area_province_id'));
            }
            
            if ($request->has('area_city_id')) {
                $query->where('area_city_id', $request->input('area_city_id'));
            }
            
           
        });
    }
}