<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Repositories\OrderlistRepository;
use App\Services\Orderlist\OrderlistService;
use App\Repositories\Criteria\Orderlist\Time;

class BuyOrderController extends Controller
{
    //
    private $repository = null;
    public function  __construct(OrderlistRepository $repository)
    {
        $this->repository = $repository;
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
            case 'BuyOrder':
                $service = app('App\Services\Orderlist\OrderlistService');
                $result = $service->get();
                break;
            case 'select':
                $service = app('App\Services\Orderlist\OrderlistService');
                $result = $service->get();
                break;
            default:
                $service = app('App\Services\Orderlist\OrderlistService');
                $result = $service->get();
        }
        return $result;
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
        //var_dump(Department::find($id));die();
        $re = $this->repository->update($request->input(), $id);
        if ($re) {
            return $this->success($re);
            //return 1;
        } else {
            return $this->error();
            //return 2;
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
            //return $this->success(1);
            return 1;
        } else {
            //return $this->error();
            return 2;
        }
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
        //throw new \Exception('test');
        //dd($request->input());
        $re = $this->repository->create($request->input());
        if ($re) {
            return $this->success($re);
        } else {
            return $this->error($re);
        }
    }
}
