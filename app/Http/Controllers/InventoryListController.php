<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InventoryListController extends Controller
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
                    'name' => '老白金',
                    'type_text' => '保健品',
                    'phone' => '15',
                    'qq' => '324568554',
                    'weixin' => '012',
                    'address' => '15645555555555',
                    'id_card' => '李清',
                ],
                [
                    'name' => '老白金',
                    'type_text' => '保健品',
                    'phone' => '15',
                    'qq' => '324568554',
                    'weixin' => '012',
                    'address' => '15645555555555',
                    'id_card' => '李清',
                ],

            ],
            'total'=>100

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
