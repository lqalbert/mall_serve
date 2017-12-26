<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\GroupRepository;
use App\Models\Group;

class GroupController extends Controller
{
    private $repository = null;
    
    public function  __construct(GroupRepository $reporitory) 
    {
        $this->repository = $reporitory;
        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
    
        $business = $request->query('business', 'default');
        $result = [];
        switch ($business) {
            case 'select':
                $result =  [
                'items'=>[
                'id'=>1,
                'name'=>'asdfasf'
                    ],
                    [
                    'id'=>1,
                    'name'=>'asdfasf'
                        ],
                        [
                        'id'=>1,
                        'name'=>'asdfasf'
                            ]
                            ];
            default:
                $service = app('App\Services\Group\GroupService');
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //update 返回 bool
        $re = $this->repository->update($request->input(), $id);
        if ($re) {
            return $this->success(Group::find($id));
        } else {
            return $this->error();
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
        //返回 int
        $re = $this->repository->delete($id);
        if ($re) {
            return $this->success(1);;
        } else {
            return $this->error();
        }
    }
}
