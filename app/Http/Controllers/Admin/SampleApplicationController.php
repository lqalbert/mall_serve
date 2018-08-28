<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SampleApplicationController extends Controller
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
                    'use_remark'=>'你先试用一下1',
                    'goods_name'=>'大力金刚丸1',
                    'num'=>888888,
                    'applicant'=>'多尔衮',
                    'operator'=>'袁承志',
                    'check_status'=>1,
                    'app_time'=>'2018-08-27 17:08:08',
                    'goods'=>[
                        [
                            'barcode'=>"201807121023",
                            'bubble_bag'=>'',
                            'goods_id'=>5,
                            'goods_name'=>"补腰一号",
                            'goods_number'=>6,
                            'height'=>"40",
                            'len'=>"30",
                            'moneyNotes'=>606,
                            'price'=>"101",
                            'remark'=>"",
                            'sku_id'=>0,
                            'sku_name'=>null,
                            'sku_sn'=>"201807121023",
                            'specifications'=>"110",
                            'unit_type'=>1,
                            'weight'=>"100",
                            'width'=>"30"
                        ],
                        [
                            'barcode'=>"201807121023",
                            'bubble_bag'=>'',
                            'goods_id'=>5,
                            'goods_name'=>"补腰一号",
                            'goods_number'=>6,
                            'height'=>"40",
                            'len'=>"30",
                            'moneyNotes'=>606,
                            'price'=>"101",
                            'remark'=>"",
                            'sku_id'=>0,
                            'sku_name'=>null,
                            'sku_sn'=>"201807121023",
                            'specifications'=>"110",
                            'unit_type'=>1,
                            'weight'=>"100",
                            'width'=>"30"
                        ]
    
                    ]
                ],
                [
                    'use_remark'=>'你先试用一下2',
                    'goods_name'=>'大力金刚丸2',
                    'num'=>888888,
                    'applicant'=>'多尔衮',
                    'operator'=>'袁承志',
                    'check_status'=>1,
                    'app_time'=>'2018-08-27 17:08:08',
                    'goods'=>[
                        [
                            'barcode'=>"201807121023",
                            'bubble_bag'=>'',
                            'goods_id'=>5,
                            'goods_name'=>"补腰一号",
                            'goods_number'=>6,
                            'height'=>"40",
                            'len'=>"30",
                            'moneyNotes'=>606,
                            'price'=>"101",
                            'remark'=>"",
                            'sku_id'=>0,
                            'sku_name'=>null,
                            'sku_sn'=>"201807121023",
                            'specifications'=>"110",
                            'unit_type'=>1,
                            'weight'=>"100",
                            'width'=>"30"
                        ],
                        [
                            'barcode'=>"201807121023",
                            'bubble_bag'=>'',
                            'goods_id'=>5,
                            'goods_name'=>"补腰一号",
                            'goods_number'=>6,
                            'height'=>"40",
                            'len'=>"30",
                            'moneyNotes'=>606,
                            'price'=>"101",
                            'remark'=>"",
                            'sku_id'=>0,
                            'sku_name'=>null,
                            'sku_sn'=>"201807121023",
                            'specifications'=>"110",
                            'unit_type'=>1,
                            'weight'=>"100",
                            'width'=>"30"
                        ]
    
                    ]
                ],
                [
                    'use_remark'=>'你先试用一下3',
                    'goods_name'=>'大力金刚丸3',
                    'num'=>888888,
                    'applicant'=>'多尔衮',
                    'operator'=>'袁承志',
                    'check_status'=>2,
                    'app_time'=>'2018-08-27 17:08:08',
                    'goods'=>[
                        [
                            'barcode'=>"201807121023",
                            'bubble_bag'=>'',
                            'goods_id'=>5,
                            'goods_name'=>"补腰一号",
                            'goods_number'=>6,
                            'height'=>"40",
                            'len'=>"30",
                            'moneyNotes'=>606,
                            'price'=>"101",
                            'remark'=>"",
                            'sku_id'=>0,
                            'sku_name'=>null,
                            'sku_sn'=>"201807121023",
                            'specifications'=>"110",
                            'unit_type'=>1,
                            'weight'=>"100",
                            'width'=>"30"
                        ],
                        [
                            'barcode'=>"201807121023",
                            'bubble_bag'=>'',
                            'goods_id'=>5,
                            'goods_name'=>"补腰一号",
                            'goods_number'=>6,
                            'height'=>"40",
                            'len'=>"30",
                            'moneyNotes'=>606,
                            'price'=>"101",
                            'remark'=>"",
                            'sku_id'=>0,
                            'sku_name'=>null,
                            'sku_sn'=>"201807121023",
                            'specifications'=>"110",
                            'unit_type'=>1,
                            'weight'=>"100",
                            'width'=>"30"
                        ]
    
                    ]
                ],
    
            ],
            'total'=>888888
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
