<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Repositories\EmployeeRepository;
use App\Services\Employee\EmployeeService;
use App\Events\AddEmployee;
use Illuminate\Support\Facades\DB;

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
            	$result = $this->repository->all($request->input('fields', ['id', 'realname']));  	
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
         $data=DB::table('user_basic')->where('user_basic.group_id','=',$gid)->select('id','realname')->get();
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
        $data['password'] = bcrypt($data['password']);
        $re = $this->repository->create($data);
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
        $re = $this->repository->update($request->input(), $id);
        if ($re) {
            return $this->success(User::find($id));
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
        $re = $this->repository->delete($id);
        if ($re) {
            return $this->success(1);
        } else {
            return $this->error(0);
        }
    }
}
