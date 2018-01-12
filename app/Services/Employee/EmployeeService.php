<?php
namespace  App\Services\Employee;

use App\Repositories\EmployeeRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeService
{
    private $repository = null;
    
    private $request = null;
    
    public function  __construct(EmployeeRepository $repositiry, Request $request) 
    {
        $this->repository = $repositiry;
        $this->request = $request;
    }
  public function getData()
  {
      $fields=['user_basic.id','user_basic.account','user_basic.realname','user_basic.head','user_basic.qq','user_basic.qq_nickname','user_basic.sex','user_basic.telephone','user_basic.mobile_phone','user_basic.id_card','user_basic.weixin','user_basic.weixin_nickname','user_basic.address','location','user_basic.ip','user_basic.create_name','department_basic.name as department_name','group_basic.name as group_name'];

        $where=[];
        $result =DB::table('user_basic')
            ->join('department_basic','department_basic.id','=','user_basic.department_id')
            ->join('group_basic','group_basic.id','=','user_basic.group_id')
            ->whereNull('user_basic.deleted_at')
            ->whereNull('department_basic.deleted_at')
            ->whereNull('group_basic.deleted_at')
            ->select($fields)
            ->get();
        $count =DB::table('user_basic')
            ->join('department_basic','department_basic.id','=','user_basic.department_id')
            ->join('group_basic','group_basic.id','=','user_basic.group_id')
            ->whereNull('user_basic.deleted_at')
            ->whereNull('department_basic.deleted_at')
            ->whereNull('group_basic.deleted_at')
            ->select($fields)
            ->count();
      return [
          'items'=>$result,
          'total'=>$count
      ];
  }
    public function  get() 
    {
        $re = $this->repository->with(['department_basic'])->all();
        return [
            'items'=>$re->getCollection(),
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