<?php
namespace  App\Services\Employee;

use App\Repositories\EmployeeRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use APP\models\User;
use App\Alg\ModelCollection;
class EmployeeService
{
    private $repository = null;

    private $request = null;
    private $model = null;

    public function  __construct(EmployeeRepository $repositiry, Request $request,User $user)
    {
        $this->repository = $repositiry;
        $this->request = $request;
        $this->model = $user;
    }
    public function getData()
    {
        $fields=['user_basic.*','roles.display_name as role_name','department_basic.name as department_name','group_basic.name as group_name'];
        $where=[];
        $result =$this->model
            ->join('department_basic','department_basic.id','=','user_basic.department_id')
            ->join('group_basic','group_basic.id','=','user_basic.group_id')
            ->join('roles','roles.id','=','user_basic.role_id')
            ->whereNull('user_basic.deleted_at')
            ->whereNull('department_basic.deleted_at')
            ->whereNull('group_basic.deleted_at')
            ->select($fields)
            ->get();
        $count =$this->model
            ->join('department_basic','department_basic.id','=','user_basic.department_id')
            ->join('group_basic','group_basic.id','=','user_basic.group_id')
            ->join('roles','roles.id','=','user_basic.role_id')
            ->whereNull('user_basic.deleted_at')
            ->whereNull('department_basic.deleted_at')
            ->whereNull('group_basic.deleted_at')
            ->select($fields)
            ->count();
        $users=[];
        foreach ($result as $v){
            $users[$v->id]=$v;
        }
        return [
            'users'=>$users,
            'items'=>$result,
            'total'=>$count
        ];
    }
    public function  get()
    {
        $re = $this->repository->with(['department','group','roles'])->paginate(20);
        $collection  = $re->getCollection();
        
        return [
        	'items'=>$collection,
            'total'=>$re->total()
        ];
    }
}
