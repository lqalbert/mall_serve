<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\InventorySystem;
use App\Models\EntrepotProductCategory;

class StockCheckController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $fields = [
            'id',
            'entrepot_id',
            'goods_name',
            'sku_sn',
            'entrepot_count',
            'entry_at',
        ];
        
        $model = new InventorySystem();
        
        if ($request->has('entrepot_id')) {
            $model = $model->where('entrepot_id', $request->input('entrepot_id'));
        }
        
        if ($request->has('goods_name')) {
            $model = $model->where('goods_name', 'like', $request->input('goods_name')."%");
        }
        
        if ($request->has('sku_sn')) {
            $model = $model->where('sku_sn', 'like', $request->input('sku_sn')."%");
        }

        if($request->has('cate_type_id')) {
            $cate_type_id = $request->input('cate_type_id');
            $model = $model->wherehas('goods', function($query) use($cate_type_id) {
                $query->where('cate_type_id', $cate_type_id);
            });
        }
        
        $result = $model->paginate($request->input('pageSize', 20), $fields);
        
        $collection = $result->getCollection();
        $collection->load('entrepot','goods','profitLoss');
        
        $re = $collection->toArray();
        
        $range = [];
        if($request->has('start') && $request->has('end')) {
            $range[] = $request->input('start');
            $range[] = $request->input('end');
        }
        
        
        ///生产入库数量   
        //退货入库数量     
        //销售锁定数 order_goods  created_at
        //发货锁定数 assign_basic created_at
        //换货锁定数  还没有
        
        // $this->getSte($re, $range);
        // logger($re);
        return [
            'items'=> $re,
            'total'=> $result->total()
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
