<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Services\Department\DepartmentService;
use App\Repositories\DepartmentRepository;
use App\Repositories\Criteria\Department\Type;

class DepartmentController extends Controller
{

    private $repository = null;
    public function  __construct(DepartmentRepository $departmentReporitory) 
    {
        $this->repository = $departmentReporitory;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        // return ['id'=>1,'name'=>'asdf'];
      $business = $request->query('business', 'default');

        $result = [];
        switch ($business) {
            case 'DepartmentType':
                $result = Department::getType();
                var_dump('11');
                break;
            case 'select':
                if ($request->has('type')) {
                    $type = new Type($request->input('type')); // $request->type;
                    $this->repository->pushCriteria($type);
                }
                $result = $this->repository->all($request->input('fields')); 
                $result->makeHidden([
                    'type_text',
                    'user',
                    'phone'
                ]);
                break;
            default:
//                 $service = new DepartmentService($this->repository);
                $service = app('App\Services\Department\DepartmentService');
              //  var_dump($service);die;
                $result = $service->get();
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
     * @param \Illuminate\Http\Request $request            
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
//         throw new \Exception('test');
//         dd($request->input());
        $re = $this->repository->create($request->input());
        if ($re) {
            return $this->success($re);
        } else {
            return $this->error();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id            
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id            
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request            
     * @param int $id            
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //update 返回 bool
        $re = $this->repository->update($request->input(), $id);
        if ($re) {
            return $this->success(Department::find($id));
        } else {
            return $this->error();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id            
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //返回 int
        $re = $this->repository->delete($id);
        if ($re) {
            return $this->success(1);;
        } else {
            return $this->error();
        }
    }
}
