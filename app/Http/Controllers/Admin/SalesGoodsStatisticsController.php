<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\PurchaseOrderGoods;

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
//         if($request->has('goods_name')){
//             $where[] = ['goods_name','like',$request->input('goods_name')."%"];
//         }

        $inventoryBuilder = $this->inInventory($start, $end);
        $saleBuilder = $this->saleNUm($start, $end);
        $innerSaleBuilder = $this->innerSaleNum($start, $end);
        $shopSaleBuilder = $this->shopSaleNum($start, $end);
        $refundBuilder = $this->refundNum($start, $end);

        $result = DB::table('inventory_system as iso')->select(
                        'iso.sku_sn','iso.goods_name',
                        DB::raw('iso.produce_in as produce_in_total'),
                        DB::raw('iso.entrepot_count as saleable_count'),
                        DB::raw("inven.goods_num as invent_num"),
                        DB::raw('sale.goods_num as sale_num'),
                        DB::raw('refu.goods_num as ref_num'),
                        DB::raw('inner_sale.goods_num as inner_num'),
                        DB::raw('shop_sale.goods_num as shop_sale'),
                        DB::raw('inven.goods_num as invent_num'))
                    ->leftJoin(DB::raw("({$inventoryBuilder->toSql()}) as inven"),'iso.sku_sn','=','inven.sku_sn')
                    ->mergeBindings($inventoryBuilder)
                    ->leftJoin(DB::raw("({$saleBuilder->toSql()}) as sale"), 'iso.sku_sn','=','sale.sku_sn')
                    ->mergeBindings($saleBuilder)
                    ->leftJoin(DB::raw("({$innerSaleBuilder->toSql()}) as inner_sale"),'iso.sku_sn','=','inner_sale.sku_sn')
                    ->mergeBindings($innerSaleBuilder)
                    ->leftJoin(DB::raw("({$shopSaleBuilder->toSql()}) as shop_sale"),'iso.sku_sn','=','shop_sale.sku_sn')
                    ->mergeBindings($shopSaleBuilder)
                    ->leftJoin(DB::raw("({$refundBuilder->toSql()}) as refu"),'iso.sku_sn','=','refu.sku_sn')
                    ->mergeBindings($refundBuilder)
                    ->where($where)->orderBy($orderField,$orderWay)
                    ->paginate($pageSize);

        return [
            'items'=>$result->items(),
            'total'=>$result->total()
        ];
    }
    
    /**
     * 累计入库总数
     */
    private function inInventory($start, $end)
    {
        return DB::table('purchase_order_goods')->select(
            DB::raw("sum(`goods_purchase_num`) as goods_num"),
            'sku_sn')
//         ->where([
//             ['created_at',">=", $start],
//             ['created_at',"<=", $end]
//         ])
        ->whereNotNull('deleted_at')
        ->groupBy('sku_sn'); 
    }
    
    
    /**
     * 本次销售数量 销售订单
     * @param unknown $start
     * @param unknown $end
     * @return unknown
     */
    private function saleNUm($start, $end)
    {
        return DB::table('order_basic')->select(
            DB::raw("sum(`goods_number`) as goods_num"),
            'sku_sn'
            )
        ->join('order_goods','order_basic.id','=','order_goods.order_id')
        ->where([
            ['order_basic.status','>=',1],
            ['order_basic.status','<=',6],
            ['order_basic.type','=',3], //不销售订单
            ['order_basic.created_at',">=", $start],
            ['order_basic.created_at',"<=", $end],
            ['order_goods.status','<>',3]
        ])->groupBy('sku_sn');
    }
    
    /**
     * 内部订单
     * @param unknown $start
     * @param unknown $end
     * @return unknown
     */
    private function innerSaleNum($start, $end)
    {
        return DB::table('order_basic')->select(
            DB::raw("sum(`goods_number`) as goods_num"),
            'sku_sn'
            )
            ->join('order_goods','order_basic.id','=','order_goods.order_id')
            ->where([
                ['order_basic.status','>=',1],
                ['order_basic.status','<=',6],
                ['order_basic.type','=',2], // 内部的订单
                ['order_basic.created_at',">=", $start],
                ['order_basic.created_at',"<=", $end],
                ['order_goods.status','<>',3]
            ])->groupBy('sku_sn');
    }
    
    private function shopSaleNum($start, $end)
    {
        return DB::table('order_basic')->select(
            DB::raw("sum(`goods_number`) as goods_num"),
            'sku_sn'
            )
            ->join('order_goods','order_basic.id','=','order_goods.order_id')
            ->where([
                ['order_basic.status','>=',1],
                ['order_basic.status','<=',6],
                ['order_basic.type','=',1], //商城的订单
                ['order_basic.created_at',">=", $start],
                ['order_basic.created_at',"<=", $end],
                ['order_goods.status','<>',3]
            ])->groupBy('sku_sn');
    }
    
    
    private function refundNum($start, $end)
    {
        return DB::table('order_after')->select(
            DB::raw("sum(`goods_number`) as goods_num"),
            'sku_sn'
            )
            ->join('order_goods','order_after.order_id','=','order_goods.order_id')
            ->where([
//                 ['order_basic.status','>=',1],
//                 ['order_basic.status','<=',6],
                ['order_after.created_at',">=", $start],
                ['order_after.created_at',"<=", $end],
                ['order_goods.status','=',1]
            ])->groupBy('sku_sn');
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
