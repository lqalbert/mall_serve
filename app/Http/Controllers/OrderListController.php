<?php

namespace App\Http\Controllers;

use App\Models\Orderlist;
use Illuminate\Http\Request;
use App\Repositories\OrderlistRepository;
use App\Services\Orderlist\OrderlistService;
use App\Repositories\Criteria\Orderlist\Time;

class OrderlistController extends Controller
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
            case 'Orderlist':
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
            return $this->success(Orderlist::find($id));
            //return 1;
        } else {
            return $this->error();
            //return 2;
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
            //return $this->success(1);
            return 1;
        } else {
            //return $this->error();
            return 2;
        }
    }
}
