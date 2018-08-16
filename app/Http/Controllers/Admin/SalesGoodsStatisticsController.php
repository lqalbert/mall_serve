<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class SalesGoodsStatisticsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $start = $request->input('start')." 00:00:00";
        $end = $request->input('end')." 23:59:59";
        $pageSize = $request->input('pageSize', 15);
        $orderField = $request->input('orderField','produce_in_total');
        $orderWay  = $request->input('orderWay','desc');
        $where = [
            // ['cb.created_at','>=',$start],
            // ['cb.created_at','<=',$end],
        ];
        if($request->has('goods_name')){
            $where[] = ['goods_name','like',$request->input('goods_name')."%"];
        }

        $result = DB::table('inventory_system as is')->select(
                        'is.sku_sn','is.goods_name',
                        DB::raw('is.produce_in as produce_in_total'),
                        DB::raw('is.entrepot_count as saleable_count')
                    )->where($where)->orderBy($orderField,$orderWay)
                    ->paginate($pageSize);

        return [
            'items'=>$result->items(),
            'total'=>$result->count()
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
