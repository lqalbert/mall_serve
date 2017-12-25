<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return [
            'items'=>[
                [
                        'head'=> '',
                        'account'=> '李青',
                        'realname'=> '李青',
                        'department_name'=> '成都部',
                        'role'=> '普通员工',
                        'sex'=> '男',
                        'id_card'=> '52148962466558875112',
                        'phone'=> '028-12354',
                        'mphone'=> '13524674554',
                        'qq'=> '325641574',
                        'qq_nickname'=> 'sb',
                        'weixin'=> 'sdfsdf',
                        'weixin_nikname'=> 'fsdfs',
                        'address'=> '天堂一街',
                        'ip'=> '192.168.0.11',
                        'location'=> '成都',
                        'lg_time'=> '2017-11-24 17=>08=>41',
                        'out_time'=> '2017-11-24 19=>08=>41',
                        'creator'=> '系统管理员',
                        'created_at'=> '2017-11-28 14=>35=>10'
                ]
            ],
            'total'=>400
            
        ];
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
        //
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
