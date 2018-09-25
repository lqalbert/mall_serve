<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Services\Customer\CustomerService;
use App\Models\CustomerUser;
use App\Models\CustomerApp;
use App\Models\User;
use App\Events\SetCustomerUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use App\Events\ContactConflict;
use App\Models\CustomerTrackLog;
use Illuminate\Support\Collection;
use App\Models\AccountSettings;
use App\Models\Department;
use Symfony\Component\Console\Tests\CustomApplication;

class CustomerController extends Controller
{
    private $service = null;
    private $request = null;

    public function  __construct(CustomerService $CustomerService) //Request $request
    {
        $this->service = $CustomerService;
//         $this->request = $request;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $business = $request->query('business', 'default');
        $result = [];
        switch ($business) {
            case 'customerType':
                $result = CustomerApp::getType();
                break;
            case 'customerSource':
                $result = CustomerApp::getSource();
                break;
            case 'complainType':
                $result = CustomerApp::getComplainType();
                break;
            default:
                $result = $this->service->get();
                break;
        }
        return $result; 

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $user = auth()->user();
        if (!$user->hasGroup()) {
            return $this->error([], '未分配小组，不能添加客户');
//             throw new \Exception();
        }
        
//         if (!$request->has('department_id')) {
//             return $this->error([], '未分配部门，你还不能添加');
//         }
        
        try {
            $this->validate($request, [
                'phone' => ['nullable','unique:customer_contact'],
                'qq' => ['nullable','unique:customer_contact'],
                'weixin' => ['nullable','unique:customer_contact'],
//                 'department_id' =>'required'
            ]);
        } catch (ValidationException $e) {
            $phone = $request->input('phone');
            $qq = $request->input('qq');
            $weixin = $request->input('weixin');
            $data = [];
            $cus_id_by_qq = null;
            $data['user_id'] = $user->toArray()['id'];
            $data['user_name'] = $user->toArray()['realname'];
            $cus_id_by_phone = DB::table('customer_contact')->where('phone',$phone)->value('cus_id');
            if($qq){
                $cus_id_by_qq = DB::table('customer_contact')->where('qq',$qq)->value('cus_id');
            }
            $cus_id_by_weixin = DB::table('customer_contact')->where('weixin',$weixin)->value('cus_id');
            if($cus_id_by_qq){
                $data['cus_id'] = $cus_id_by_qq;
                $data['cus_name'] = DB::table('customer_basic')->where('id',$cus_id_by_qq)->value('name');
                $data['content'] = '添加客户时与QQ号'.$qq.'冲突';
            }
            if($cus_id_by_weixin){
                $data['cus_id'] = $cus_id_by_weixin;
                $data['cus_name'] = DB::table('customer_basic')->where('id',$cus_id_by_weixin)->value('name');
                $data['content'] = '添加客户时与微信号'.$weixin.'冲突';
            }
            if($cus_id_by_phone){
                $data['cus_id'] = $cus_id_by_phone;
                $data['cus_name'] = DB::table('customer_basic')->where('id',$cus_id_by_phone)->value('name');
                $data['content'] = '添加客户时与手机号码'.$phone.'冲突';
            }
            $re = CustomerTrackLog::create($data);
            if($re){
                event( new ContactConflict($e->validator->errors(), $request->only(['phone','qq','weixin'])));
                throw $e;
            }
        }
        
        
        try {
           
            $this->service->storeData();
        } catch (\Exception $e) {
            return $this->error([], $e->getMessage());
        }
        
        return $this->success([]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
       $re =  $this->service->upDate($id);
       if ($re) {
           return $this->success([]);
       } else {
           return $this->error([]);
       }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->service->destroyData($id);
        return $this->success([]);
    }
    
    /**
     * 转让
     * @todo  20 多个就GG了 
     */
    public function transfer(Request $request)
    {
    	//user_id
    	//cus_ids
    	$from_id = $request->input('from_id');
    	if (!$from_id) {
    		return $this->error(0);
    	}
    	$user_id = $request->input('user_id');
    	if (!$user_id) {
    		return $this->error(0);
    	}
    	
    	if ($from_id == $user_id) {
    		return $this->error(0);
    	}
    	
    	
    	$userModel = User::select(['id','realname','group_id','department_id'])
    					   ->with(['group','department'])
    					   ->where('id', $user_id)
    					   ->first();
    	$cus_ids = $request->input('cus_ids');
    	foreach ($cus_ids as $id) {
//     		$model  = CustomerUser::where('cus_id', $id)->first();
    		event(new SetCustomerUser( $userModel ,$id, CustomerUser::TRANSFER) );
    	  
    	}
    	
    	return $this->success(1);
    }
    
    /**
     * 离职接收
     * @todo 转移代码到 service 层 需要重构
     */
    public function quitTransfer(Request $request)
    {

    	$user_ids= $request->input('user_ids');
    	if (empty($user_ids)) {
    		return $this->error();
    	}
    	$user_id = $request->input('to_id');
    	if (!$user_id) {
    		return $this->error(0, '目标用户');
    	}
    	
    	if (in_array($user_id, $user_ids)) {
    		return $this->error();
    	}
    	
    	$userModel = User::select(['id','realname','group_id','department_id'])
			    	->with(['group','department'])
			    	->where('id', $user_id)
			    	->first();
    	
    	foreach ($user_ids as $from_id) {
    		
    		$cus_ids = CustomerUser::where('user_id', $from_id)->pluck('cus_id');
    		if (empty($cus_ids)) {
    			continue;
    		}
    		foreach ($cus_ids as $id) {
                
    			event(new SetCustomerUser(
    			        $userModel,
    			        $id,
    					CustomerUser::QUIT ));
    			
    		}
    	}
    	
    	return $this->success(1);	
    }
    
    /**
     * 统计前台导入的用户数量
     * 1 选出人 select user_id from account_settiongs
     * 2 select count(distinct cus_id), user_name, department_id, department_name from customer_user where user_id in (上一步)
     * 3 返回统计的结果
     * 
     * @return Collection || array
     */
    public function frontLedIn()
    {
        
        $users = AccountSettings::pluck('user_id');
        if ($users->isEmpty()) {
            return [
                'items'=>[],
                'total'=>0
            ];
        }
//         $re = CustomerUser::whereIn('user_id', $users)
        $re = DB::table('customer_user')->select('user_name','user_id','department_id',
            'department_name', 
            DB::raw("count(distinct cus_id) as cus_count"))
            ->whereIn("user_id", $users->all())
            ->whereNull('deleted_at')
            ->groupBy('user_id')
            ->get();
        return [
            'items' =>   $re->all(),
            'total' =>  $re->count()
        ];
    }
    
    /**
     * allocate to department
     * @param Request $request
     * @return number[]|string[]|NULL[]
     */
    public function transferFrontLedIn(Request $request)
    {
        $max = 300;
        
        $department_id = $request->input('department_id');
        $source_id = $request->input('source_id');
        
        $department = Department::find($department_id);
        $cus = CustomerUser::whereIn('department_id', $source_id)->limit($max)->get();
        //批量插入
        $inserts = [];
        $created_at = Date("Y-m-d H:i:s");
        $transUserId = [];
        foreach ($cus as $item){
            $tmp = [
                'user_id'=>0,
                'cus_id' => $item->cus_id,
                'type' => CustomerUser::ALLOCATE,
                'group_id'=>0,
                'department_id'=>$department_id,
                'department_name'=>$department->name,
                'user_name'=>'',
                'created_at'=>$created_at,
                'updated_at'=>$created_at
            ];
            $inserts[] = $tmp;
            
            $transUserId[] = $item->id;
        }
        $re =  DB::table('customer_user')->insert($inserts);
        CustomerUser::destroy($transUserId);
        if ($re) {
            return $this->success([]);
        } else {
            return $this->error([]);
        }
    }
    
    
    /**
     * 获取部门待分配下去总数
     */
    public function getNumAllowAllocat(Request $request)
    {
        $department_id = $request->input('department_id');
        $re = CustomerUser::where('department_id', $department_id)->where('user_id',0)->count();
        
        return [
            'total'=>$re
        ];
    }
    
    /**
     * 
     * @param Request $request
     */
    public function allocateToUser(Request $request)
    {
        $allocated = $request->input('allocated');
        $department_id = $request->input('department_id');
        
        $allocated = collect($allocated);
        $user = User::whereIn('id', $allocated->pluck('id'))->select('id','group_id')->with('group')->get();
        $user = $user->keyBy('id');
        
        DB::beginTransaction();
        foreach ($allocated as $item) {
            $currentUser = $user->get($item->id);
            $re = CustomerUser::where('department_id', $department_id)->where('user_id',0)
            ->orderBy('id','asc')
            ->limit($item->num)
            ->update([
                'user_id'=>$item->id,
                'user_name'=>$item->realname,
                'group_id'=>$currentUser->group_id,
                'group_name'=>$currentUser->group->name
            ]);
            if ($re == 0) {
                DB::rollback();
                return $this->error([], '失败');
            }
        }
        DB::commit();
        
        return $this->success([]);
        
        
    }
}
