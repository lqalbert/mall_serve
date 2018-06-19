<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\InventorySystem;
use App\Models\StockCheckGoods;
use App\Models\StockCheck;
use Illuminate\Support\Facades\DB;

class StockCheckGoodsController extends Controller
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
        
        if ($request->has('sku_sn')) {
            $model = $model->where('sku_sn', 'like', $request->input('sku_sn')."%");
        }

        if ($request->has('goods_name')) {
            $model = $model->where('goods_name', 'like', $request->input('goods_name')."%");
        }
        
        if($request->has('cate_type_id')) {
            $cate_type_id = $request->input('cate_type_id');
            $model = $model->wherehas('goods', function($query) use($cate_type_id) {
                $query->where('cate_type_id', $cate_type_id);
            });
        }

        if($request->has('cate_kind_id')) {
            $cate_kind_id = $request->input('cate_kind_id');
            $model = $model->wherehas('goods', function($query) use($cate_kind_id) {
                $query->where('cate_kind_id', $cate_kind_id);
            });
        }
        
        $result = $model->select($fields)->get();
        
        $result->load('entrepot','category');
        
        $re = $result->toArray();
        
        return [
            'items'=> $re,
            'total'=> $result->count()
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
        DB::beginTransaction();
        try {
            $checkNum = "PD".time();
            $allData = $request->all();
            $allData['check_num'] = $checkNum;
            $stockCheck = StockCheck::make($allData);
            $re = $stockCheck->save();
            if (!$re) {
                throw new  \Exception('创建盘点单子失败');
            }
            $stockCheckGoodsModels = [];
            foreach ($request->input('check_goods_data') as $checkGoods) {
                $checkGoods['check_num'] = $checkNum;
                $stockCheckGoodsModels[] = StockCheckGoods::make($checkGoods);
            }
            if (!empty($stockCheckGoodsModels)) {
                $stockCheck->goods()->saveMany($stockCheckGoodsModels);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return  $this->error([], $e->getMessage());
        }
        return $this->success([$stockCheck->id]);
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
