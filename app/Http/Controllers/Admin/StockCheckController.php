<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StockCheckController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return [
            'items'=>[
                [
                    'check_num'=>1314520,
                    'goods_name'=>'长久丸子',
                    'cate_type_id'=>'大保健',
                    'entrepot_count'=>'100',
                    'release_money'=>'50000.01',
                    'resp_money'=>'40000.02',
                    'created_at'=>'2018-05-15 11:13:09',
                ],
                [
                    'check_num'=>1314520,
                    'goods_name'=>'长久丸子',
                    'cate_type_id'=>'大保健',
                    'entrepot_count'=>'100',
                    'release_money'=>'50000.01',
                    'resp_money'=>'40000.02',
                    'created_at'=>'2018-05-15 11:13:09',
                ],
                [
                    'check_num'=>1314520,
                    'goods_name'=>'长久丸子',
                    'cate_type_id'=>'大保健',
                    'entrepot_count'=>'100',
                    'release_money'=>'50000.01',
                    'resp_money'=>'40000.02',
                    'created_at'=>'2018-05-15 11:13:09',
                ],

            ],
            'total'=>3
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
