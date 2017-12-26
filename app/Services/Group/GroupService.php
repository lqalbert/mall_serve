<?php
namespace App\Services\Group;

use App\Repositories\GroupRepository;
use Illuminate\Http\Request;
use App\Repositories\Criteria\Group\Department;

class GroupService
{
    private $repository = null;
    
    private $request = null;
    
    public function  __construct(GroupRepository$repository, Request $request) 
    {
        $this->repository = $repository;
        $this->request = $request;
    }
    
    public function  get() 
    {
        if ($this->request->has('department_id')) {
            $this->repository->pushCriteria(new Department($this->request->input('department_id')));
        }
        
        $result = $this->repository->paginate();
        $collection  = $result->getCollection();
//         foreach ($collection as &$value) {
//             $value->department;
//         }
        return [
            'items'=> $collection->makeHidden('department'),
            'totle'=> $result->total()
        ];
        
    }
}