<?php
namespace  App\Services\Employee;

use App\Repositories\EmployeeRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use APP\models\User;
use App\Alg\ModelCollection;
use App\Repositories\Criteria\OrderByIdDesc;
use App\Repositories\Criteria\OnlyTrashed;
use App\Repositories\Criteria\Employee\DepartCandidate;
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
    
    /**
     * @todo depart-candidate 替换成常量
     * @return unknown[]|NULL[]
     */
    public function  get()
    {
        
        $this->repository->pushCriteria(new OrderByIdDesc());
        
        if ($this->request->has('status') && $this->request->input('status') == -1) {
            $this->repository->pushCriteria(new OnlyTrashed());
        }
        
        
        
        $selects = $this->request->has('fields') ? $this->request->input('fields') : ['*'];
        
        
        $re = $this->repository->with(['department','group','roles'])->paginate(20, $selects);
        $collection  = $re->getCollection();
        
        return [
        	'items'=>$collection,
            'total'=>$re->total()
        ];
        //下面的参考一下。字段没加全
//         return [
//             'items'=>[
//                 [
//                     'id'=> 1,
//                     'account'=> 'gfsdg',
//                     'realname'=> 'gsggs',
//                     'department_name'=>'hdfhd',
//                     'head'=>'gdfg',
//                     'qq'=> 'gdfh',
//                     'role'=> 'ndfhdf',
//                     'sex'=> '男' || '女',
//                     'phone'=> '132465465',
//                     'mphone'=> '23131',
//                     'remark'=>'hdghdf',
//                     'status'=>'hdfhd',
//                     'id_card'=>'dfjkhg',
//                     'qq_nickname'=>'fghdf',
//                     'weixin'=>'jfdj',
//                     'weixin_nikname'=>'kldfhgkdf',
//                     'address'=>'jfgjf',
//                     'ip'=>'192.168.0.10',
//                     'location'=>'ohigfdgjk',
//                     'lg_time'=>'2017-12-02',
//                     'out_time'=>'2017-12-02',
//                     'created_at'=>'2017-12-02',
//                     'creator'=>'fjkgjkf',
//                 ]
//             ],
//             'total'=>400
//         ];
    }
}
