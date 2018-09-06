<?php

namespace App\Http\Controllers\Admin;

use App\Models\AccountSettings;
use Illuminate\Http\Request;

class AccountSettingsController extends Controller
{
    private $model = null;

    public function  __construct(AccountSettings $AccountSettings)
    {
        $this->model = $AccountSettings;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $where = [];
        if($request->has('department_id')){
            $where[] = ['department_id','=',$request->input('department_id')];
        }
        if($request->has('group_id')){
            $where[] = ['group_id','=',$request->input('group_id')];
        }
        if($request->has('user_id')){
            $where[] = ['user_id','=',$request->input('user_id')];
        }
        $data = $this->model->where($where)->orderBy('created_at','desc')->paginate($request->input('pageSize'));
        return ['items'=>$data->items(),'total'=>$data->total()];
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
        $data = $request->all();
        $re = $this->model->create($data);
        if ($re) {
            return $this->success([]);
        } else {
            return $this->error([]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AccountSettings  $accountSettings
     * @return \Illuminate\Http\Response
     */
    public function show(AccountSettings $accountSettings)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AccountSettings  $accountSettings
     * @return \Illuminate\Http\Response
     */
    public function edit(AccountSettings $accountSettings)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AccountSettings  $accountSettings
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $re = $this->model->where('id',$id)->update($request->all());

        if ($re) {
            return $this->success([]);
        } else {
            return $this->error([]);
        }
    }

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
     * @param  \App\Models\AccountSettings  $accountSettings
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $re = $this->model->where('id',$id)->delete();
        if ($re) {
            return $this->success([]);
        } else {
            return $this->error([]);
        }
    }
}
