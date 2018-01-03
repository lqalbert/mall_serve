<?php
namespace App\Services\Customer;


use App\Repositories\CustomerRepository;
use Illuminate\Http\Request;
use App\Alg\ModelCollection;

class CustomerService
{
    private $repository = null;
    private $request = null;
    
    public function  __construct(CustomerRepository $repository, Request $request) 
    {
        $this->repository = $repository;
        $this->request = $request;
    }
    
    public function  get() 
    {
        $selectFields = ['id','name','type','sex','recommend'];   
        $result = $this->repository
                        ->with(['contacts'])
                        ->paginate($this->request->input('pageSize', 20),$selectFields);
        $appends = ['type_text', 'sex_text'];
        $collection = ModelCollection::setAppends($result->getCollection(), $appends);
        
        return $result = [
            'items'=> $collection,
            'total'=> $result->total()
        ];
    }
}