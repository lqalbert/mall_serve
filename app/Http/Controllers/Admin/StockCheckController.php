<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\InventorySystem;
use App\Models\StockCheckGoods;
use App\Models\StockCheck;
use Illuminate\Support\Facades\DB;
use App\Models\PurchaseOrderGoods;

class StockCheckController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    { 
        $model = new StockCheck();
        
        if ($request->has('check_sn')) {
            $model = $model->where('check_sn','like',$request->input('check_sn')."%");
        }

        if ($request->has('start')) {
            $model = $model->where('created_at', '>=', $request->input('start')." 00:00:00");
        }

        if ($request->has('end')) {
            $end = Date('Y-m-d H:i:s', strtotime($request->input('end')." 00:00:00")+86400) ;
            $model = $model->where('created_at', '<=', $end);
        }
        
        $result = $model->orderBy('id', 'desc')->paginate($request->input('pageSize', 6));
 
        return [
            'items'=> $result->items(),
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
        // var_dump($request->all());die();
        DB::beginTransaction();
        try {
//             $check_id = $request->input('check_id');
            $re = StockCheck::where('id',$id)->update($request->all());
//             if(!$re){
//                 throw new  \Exception('盘点状态改变失败');
//             }
//             StockCheckGoods::where('id',$id)->update($request->except(['check','purchase_price','updated_at','created_at']));
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return  $this->error([], $e->getMessage());
        }
        return $this->success([]);
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

    /**
     * [getCheckGoods 获取盘点商品]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function getCheckGoods(Request $request){
        
        // echo $request->input('check_id');die();
        $model = new StockCheckGoods();
        
        // if ($request->has('check_sn')) {
        //     $model = $model->where('check_sn', $request->input('check_sn'));
        // }
        
        if ($request->has('check_id')) {
            $model = $model->where('check_id', $request->input('check_id'));
        }
        
        $result = $model->get();

        $result->load('check','purchasePrice');

        return [
            'items'=> $result->toArray(),
            'total'=> $result->count()
        ];
    }

    //获取价格 {'122323':[{value:'aaa', label:'bbb'}}
    public function getGoodsPrice(Request $request,$sku){
        // echo $sku;
        $request = PurchaseOrderGoods::where('sku_sn',$sku)->select('goods_purchase_price')->get();
        $arr = [];
        foreach ($request as $model) {
            $arr['value']= $model->goods_purchase_price;
        }
        return [
            $sku=>[$arr]
        ];
    }

}
