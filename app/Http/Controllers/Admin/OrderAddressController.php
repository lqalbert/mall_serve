<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\OrderAddress;
use App\Events\AddAssignOperationLog;

class OrderAddressController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $where = [];
        if($request->has('order_id')){
            $where[] = ['order_id','=',$request->order_id];
        }
        $result = OrderAddress::where($where)->get();

        return ['items'=>$result,'total'=>count($result)];
        
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
        $data = $request->except(['id','assign_id','assign_sn']);
        $re = OrderAddress::where('id', $id)->update($data);
        if ($re) {
            //添加发货单操作记录
            $dataLog = [
                'assign_id'=>$request->input('assign_id'),
                'action'=>'edit-address',
                'remark'=>$request->input('assign_sn')
            ];
            event(new AddAssignOperationLog(auth()->user(),$dataLog));
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
        //
    }
}
