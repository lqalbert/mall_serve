<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Repositories\EmployeeRepository;
use App\Services\Employee\EmployeeService;
use App\Events\AddEmployee;
use Illuminate\Support\Facades\DB;
use App\Repositories\Criteria\Employee\DepartCandidate;
use Illuminate\Support\Facades\Log;
use App\Repositories\Criteria\Department;
use App\Repositories\Criteria\Employee\RoleCriteria;
use App\Repositories\Criteria\Employee\Group;
use App\Repositories\Criteria\Employee\Id;
use App\Repositories\Criteria\Employee\GroupCandidate;
use App\Repositories\Criteria\NotEqual;

class EmployeeController extends Controller
{
    private $repository = null;
    private $service = null;
    public function  __construct(EmployeeRepository $repository,EmployeeService $employeeService)
    {
        $this->repository = $repository;
        $this->service = $employeeService;
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
        switch ($business){
            case 'select':
            	if ($request->has('group_id')) {
            		$this->repository->pushCriteria(new Group($request->input('group_id')));
            	}
            	
            	if ($request->has('department_id')) {
            		$this->repository->pushCriteria(new Department($request->input('department_id')));
            	}
            	
            	if ($request->has('role')) {
            		$this->repository->pushCriteria(new RoleCriteria($request->input('role')));
            	}
            	
            	if ($request->has('group_candidate')) {
            		$this->repository->pushCriteria(new GroupCandidate());
            	}
            	
            	if ($request->has('id')) {
            		$this->repository->pushCriteria(new Id($request->input('id')));
            	} 
            	
            	if ($request->has('not')) {
            		$not = json_decode($request->input('not'), true);
            		foreach ($not as  $key => $value) {
            			$this->repository->pushCriteria(new NotEqual($key, $value));
            		}
            	}
            	
            	
            	if ($request->has('with')) {
            		$this->repository->with($request->input('with'));
            	}
            	
            	
            	$re = $this->repository->all($request->input('fields', ['id', 'realname']));  
            	$result = [
            			'items' => $re,
            			'total' => count($re)
            	];
                break;
            case 'pickToGroup':
                $service = app('App\Services\Employee\PickAbleGMService');
                $result = $service->get();
                break;
            default:
                $result = $this->service->getData();
        }
        return $result;
    }
    public function getUserByGId(Request $request,$gid )
    {
        $fields=['user_basic.*','roles.name as role_name'];
         $data=DB::table('user_basic')->join('roles','roles.id','=','user_basic.role_id')->where('user_basic.group_id','=',$gid)->select($fields)->get();
        return ['items'=>$data];
    }
    /**
     * Show the form for creating a new resource.
     *
     * @param \Illuminate\Http\Reqeust
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request )
    {

    }
    public function test(Request $request )
    {
        $service = app('App\Services\Employee\EmployeeService');
        $result = $service->getData();
        return $result;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
       // DD($data);
        if(!$data['head']){
            $data['head'] = '/storage/head.jpg';
        }
        $data['password'] = bcrypt($data['password']);
        $re = DB::transaction(function()use($data, $request){
        	$re = $this->repository->create($data);
        	event(new AddEmployee($re, $request->input('role_ids',[])));
        	return $re;
        });
        
        
        if ($re) {
//             event(new AddEmployee($re));
            return $this->success($re);
        } else {
            return $this->error(0);
        }
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
    public function update(Request $request, $id)
    {
    	$re = $this->repository->update($request->except(['role_ids']), $id);
    	$mode = User::find($id);
//     	dd($mode);
        event(new AddEmployee($mode, $request->input('role_ids',[])));
        
        if ($re) {
            return $this->success(User::find($id));
        } else {
            return $this->error(0);
        }
    }
    
    /**
     * Updates the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $id
     * @return \Illuminate\Http\Response
     */
    public function updates(Request $request)
    {
    	$ids = $request->input('ids');
    	$re = User::whereIn('id', $ids)->update($request->except('ids'));
    	
    	if ($re) {
    		return $this->success([]);
    	} else {
    		return $this->error(0);
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
        //
//        $re = User::where(['id'=>$id])->update(['status'=>'-1']);
        $re = $this->repository->delete($id);
        if ($re) {
            return $this->success(1);
        } else {
            return $this->error(0);
        }
    }
}
