<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\PurchaseOrderGoods;
use Excel;

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
        $sampleBuilder = $this->sampleNum($start, $end);
        $saleMoneyBuilder = $this->saleMoney($start, $end);
        $innerSaleMoneyBuilder = $this->innerSaleMoney($start, $end);
        $shopSaleMoneyBuilder = $this->shopSaleMoney($start, $end);
        $sampleSaleMoneyBuilder = $this->sampleSaleMoney($start, $end);

        $result = DB::table('inventory_system as iso')->select(
                        'iso.sku_sn','iso.goods_name',
                        DB::raw('iso.produce_in as produce_in_total'),
                        DB::raw('iso.entrepot_count as saleable_count'),
                        DB::raw("inven.goods_num as invent_num"),
                        DB::raw('sale.goods_num as sale_num'),
                        DB::raw('refu.goods_num as ref_num'),
                        DB::raw('inner_sale.goods_num as inner_num'),
                        DB::raw('shop_sale.goods_num as shop_num'),
                        DB::raw('inven.goods_num as invent_num'),
                        DB::raw('sample.goods_num as sample_num'),
                        DB::raw('sm.money as sale_money'),
                        DB::raw('ism.money as inner_sale_money'),
                        DB::raw('ssm.money as shop_sale_money'),
                        DB::raw('spsm.money as sample_sale_money')
                    )
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
                    ->leftJoin(DB::raw("({$sampleBuilder->toSql()}) as sample"), 'iso.sku_sn','=','sample.sku_sn')
                    ->mergeBindings($sampleBuilder)
                    ->leftJoin(DB::raw("({$saleMoneyBuilder->toSql()}) as sm"),'iso.sku_sn','=','sm.sku_sn')
                    ->mergeBindings($saleMoneyBuilder)
                    ->leftJoin(DB::raw("({$innerSaleMoneyBuilder->toSql()}) as ism"),'iso.sku_sn','=','ism.sku_sn')
                    ->mergeBindings($innerSaleMoneyBuilder)
                    ->leftJoin(DB::raw("({$shopSaleMoneyBuilder->toSql()}) as ssm"),'iso.sku_sn','=','ssm.sku_sn')
                    ->mergeBindings($shopSaleMoneyBuilder)
                    ->leftJoin(DB::raw("({$sampleSaleMoneyBuilder->toSql()}) as spsm"),'iso.sku_sn','=','spsm.sku_sn')
                    ->mergeBindings($sampleSaleMoneyBuilder)
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
        ->whereNull('deleted_at')
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
            ['order_basic.type','=',3], //销售订单
            ['order_basic.created_at',">=", $start],
            ['order_basic.created_at',"<=", $end],
            ['order_goods.status','<>',3]
        ])->groupBy('sku_sn');
    }
    
    /**
     * [saleMoney 销售订单金额]
     * @param  [type] $start [description]
     * @param  [type] $end   [description]
     * @return [type]        [description]
     */
    private function saleMoney($start, $end){
        return DB::table('order_basic')->select(
                DB::raw("sum(`goods_number`*`price`) as money"),'sku_sn'
            )->join('order_goods','order_basic.id','=','order_goods.order_id')
            ->where([
                ['order_basic.status','>=',1],
                ['order_basic.status','<=',6],
                ['order_basic.type','=',3], //销售订单
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
    
    /**
     * [innerSaleMoney 内购金额]
     * @param  [type] $start [description]
     * @param  [type] $end   [description]
     * @return [type]        [description]
     */
    private function innerSaleMoney($start,$end){
        return DB::table('order_basic')->select(
                DB::raw("sum(`goods_number`*`price`) as money"),'sku_sn'
            )->join('order_goods','order_basic.id','=','order_goods.order_id')
            ->where([
                ['order_basic.status','>=',1],
                ['order_basic.status','<=',6],
                ['order_basic.type','=',2], //销售订单
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
    
    /**
     * [shopSaleMoney 商城金额]
     * @param  [type] $start [description]
     * @param  [type] $end   [description]
     * @return [type]        [description]
     */
    private function shopSaleMoney($start, $end){
        return DB::table('order_basic')->select(
                DB::raw("sum(`goods_number`*`price`) as money"),'sku_sn'
            )->join('order_goods','order_basic.id','=','order_goods.order_id')
            ->where([
                ['order_basic.status','>=',1],
                ['order_basic.status','<=',6],
                ['order_basic.type','=',1], //商城订单
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
     * 样品
     * @param unknown $start
     * @param unknown $end
     */
    private function sampleNum($start, $end) 
    {
        return DB::table('sample_basic')->select(
            DB::raw("sum(`goods_number`) as goods_num"),
            'sku_sn'
            )
            ->join('sample_goods','sample_basic.id','=','sample_goods.sample_id')
            ->where([
                ['sample_basic.check_status',1],
                ['sample_basic.check_time',">=", $start],
                ['sample_basic.check_time',"<=", $end],
            ])->groupBy('sku_sn');
    }

    /**
     * [sampleSaleMoney 退货]
     * @param  [type] $start [description]
     * @param  [type] $end   [description]
     * @return [type]        [description]
     */
    private function sampleSaleMoney($start,$end){
        return DB::table('sample_basic')->select(
                DB::raw("sum(`goods_number`*`price`) as money"),'sku_sn'
            )->join('sample_goods','sample_basic.id','=','sample_goods.sample_id')
            ->where([
                ['sample_basic.check_status',1],
                ['sample_basic.check_time',">=", $start],
                ['sample_basic.check_time',"<=", $end],
            ])->groupBy('sku_sn');
    }

//******************************************以下为部门的**************************************************************
    public function getDepSaleGoods(Request $request, $sku){
        $start = $request->input('start')." 00:00:00";
        $end = $request->input('end')." 23:59:59";

        $depSaleBuilder = $this->depSaleNUm($sku,$start, $end);
        $depSaleMoneyBuilder = $this->depSaleMoney($sku,$start, $end);
        $depInnerSaleBuilder = $this->depInnerSaleNum($sku,$start, $end);
        $depInnerSaleMoneyBuilder = $this->depInnerSaleMoney($sku,$start, $end);
        $depShopSaleBuilder = $this->depShopSaleNum($sku,$start, $end);
        $depShopSaleMoneyBuilder = $this->depShopSaleMoney($sku,$start, $end);
        $depRefundBuilder = $this->depRefundNum($sku,$start, $end);

        $result = DB::table('department_basic as db')->select(
                'db.manager_id',
                DB::raw("db.name as department_name"),
                DB::raw("ub.realname as department_manager"),
                DB::raw('ds.goods_num as sale_num'),
                DB::raw('dsm.money as sale_money'),
                DB::raw('dis.goods_num as inner_num'),
                DB::raw('dism.money as inner_sale_money'),
                DB::raw('dss.goods_num as shop_num'),
                DB::raw('dssm.money as shop_sale_money'),
                DB::raw('drf.goods_num as ref_num')

            )->join('user_basic as ub','db.manager_id','=','ub.id')
            ->leftJoin(DB::raw("({$depSaleBuilder->toSql()}) as ds"),'db.id','=','ds.department_id')
            ->mergeBindings($depSaleBuilder)
            ->leftJoin(DB::raw("({$depSaleMoneyBuilder->toSql()}) as dsm"),'db.id','=','dsm.department_id')
            ->mergeBindings($depSaleMoneyBuilder)
            ->leftJoin(DB::raw("({$depInnerSaleBuilder->toSql()}) as dis"),'db.id','=','dis.department_id')
            ->mergeBindings($depInnerSaleBuilder)
            ->leftJoin(DB::raw("({$depInnerSaleMoneyBuilder->toSql()}) as dism"),'db.id','=','dism.department_id')
            ->mergeBindings($depInnerSaleMoneyBuilder)
            ->leftJoin(DB::raw("({$depShopSaleBuilder->toSql()}) as dss"),'db.id','=','dss.department_id')
            ->mergeBindings($depShopSaleBuilder)
            ->leftJoin(DB::raw("({$depShopSaleMoneyBuilder->toSql()}) as dssm"),'db.id','=','dssm.department_id')
            ->mergeBindings($depShopSaleMoneyBuilder)
            ->leftJoin(DB::raw("({$depRefundBuilder->toSql()}) as drf"),'db.id','=','drf.department_id')
            ->mergeBindings($depRefundBuilder)
            ->where([
                ['db.type',0],
                ['db.status',1],
            ])->paginate(15);

        return [
            'items'=>$result->items(),
            'total'=>$result->total()
        ];


    }

    /**
     * 本次销售数量 销售订单
     * @param unknown $start
     * @param unknown $end
     * @return unknown
     */
    private function depSaleNUm($sku,$start, $end)
    {
        return DB::table('order_basic')->select(
            DB::raw("sum(`goods_number`) as goods_num"),
            'sku_sn','department_id'
            )
        ->join('order_goods','order_basic.id','=','order_goods.order_id')
        ->where([
            ['order_basic.status','>=',1],
            ['order_basic.status','<=',6],
            ['order_basic.type','=',3], //销售订单
            ['order_basic.created_at',">=", $start],
            ['order_basic.created_at',"<=", $end],
            ['order_goods.status','<>',3],
            ['order_goods.sku_sn',$sku]
        ])->groupBy('department_id');
    }
    
    /**
     * [saleMoney 销售订单金额]
     * @param  [type] $start [description]
     * @param  [type] $end   [description]
     * @return [type]        [description]
     */
    private function depSaleMoney($sku,$start, $end){
        return DB::table('order_basic')->select(
                DB::raw("sum(`goods_number`*`price`) as money"),'sku_sn','department_id'
            )->join('order_goods','order_basic.id','=','order_goods.order_id')
            ->where([
                ['order_basic.status','>=',1],
                ['order_basic.status','<=',6],
                ['order_basic.type','=',3], //销售订单
                ['order_basic.created_at',">=", $start],
                ['order_basic.created_at',"<=", $end],
                ['order_goods.status','<>',3],
                ['order_goods.sku_sn',$sku]
            ])->groupBy('department_id');
    }

    /**
     * 内部订单
     * @param unknown $start
     * @param unknown $end
     * @return unknown
     */
    private function depInnerSaleNum($sku,$start, $end)
    {
        return DB::table('order_basic')->select(
            DB::raw("sum(`goods_number`) as goods_num"),
            'sku_sn','department_id'
            )
            ->join('order_goods','order_basic.id','=','order_goods.order_id')
            ->where([
                ['order_basic.status','>=',1],
                ['order_basic.status','<=',6],
                ['order_basic.type','=',2], // 内部的订单
                ['order_basic.created_at',">=", $start],
                ['order_basic.created_at',"<=", $end],
                ['order_goods.status','<>',3],
                ['order_goods.sku_sn',$sku]
            ])->groupBy('department_id');
    }
    
    /**
     * [innerSaleMoney 内购金额]
     * @param  [type] $start [description]
     * @param  [type] $end   [description]
     * @return [type]        [description]
     */
    private function depInnerSaleMoney($sku,$start,$end){
        return DB::table('order_basic')->select(
                DB::raw("sum(`goods_number`*`price`) as money"),'sku_sn','department_id'
            )->join('order_goods','order_basic.id','=','order_goods.order_id')
            ->where([
                ['order_basic.status','>=',1],
                ['order_basic.status','<=',6],
                ['order_basic.type','=',2], //销售订单
                ['order_basic.created_at',">=", $start],
                ['order_basic.created_at',"<=", $end],
                ['order_goods.status','<>',3],
                ['order_goods.sku_sn',$sku]
            ])->groupBy('department_id');
    }

    private function depShopSaleNum($sku,$start, $end)
    {
        return DB::table('order_basic')->select(
            DB::raw("sum(`goods_number`) as goods_num"),
            'sku_sn','department_id'
            )
            ->join('order_goods','order_basic.id','=','order_goods.order_id')
            ->where([
                ['order_basic.status','>=',1],
                ['order_basic.status','<=',6],
                ['order_basic.type','=',1], //商城的订单
                ['order_basic.created_at',">=", $start],
                ['order_basic.created_at',"<=", $end],
                ['order_goods.status','<>',3],
                ['order_goods.sku_sn',$sku]
            ])->groupBy('department_id');
    }
    
    /**
     * [shopSaleMoney 商城金额]
     * @param  [type] $start [description]
     * @param  [type] $end   [description]
     * @return [type]        [description]
     */
    private function depShopSaleMoney($sku,$start, $end){
        return DB::table('order_basic')->select(
                DB::raw("sum(`goods_number`*`price`) as money"),'sku_sn','department_id'
            )->join('order_goods','order_basic.id','=','order_goods.order_id')
            ->where([
                ['order_basic.status','>=',1],
                ['order_basic.status','<=',6],
                ['order_basic.type','=',1], //商城订单
                ['order_basic.created_at',">=", $start],
                ['order_basic.created_at',"<=", $end],
                ['order_goods.status','<>',3],
                ['order_goods.sku_sn',$sku]
            ])->groupBy('department_id');
    }

    /**
     * [refundNum 退货数量]
     * @param  [type] $start [description]
     * @param  [type] $end   [description]
     * @return [type]        [description]
     */
    private function depRefundNum($sku,$start, $end)
    {
        return DB::table('order_after')->select(
            DB::raw("sum(`goods_number`) as goods_num"),
            'sku_sn','department_id'
            )
            ->join('order_basic','order_after.order_id','=','order_basic.id')
            ->join('order_goods','order_after.order_id','=','order_goods.order_id')
            ->where([
//                 ['order_basic.status','>=',1],
//                 ['order_basic.status','<=',6],
                ['order_after.created_at',">=", $start],
                ['order_after.created_at',"<=", $end],
                ['order_goods.status','=',1],
                ['order_goods.sku_sn',$sku]
            ])->groupBy('department_id');
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

    /**
     * [downloadExcel 下载表格excel]
     * @param  [type] $a [description]
     * @param  [type] $b [description]
     * @return [type]    [description]
     */
    public function downloadExcel(Request $request){
        var_dump($request->all());die();
        echo storage_path();die();
        $cellData = [
            ['学号','姓名','成绩'],
            ['10001','AAAAA','99'],
            ['10002','BBBBB','92'],
            ['10003','CCCCC','95'],
            ['10004','DDDDD','89'],
            ['10005','EEEEE','96'],
        ];
        Excel::create('学生成绩',function($excel) use ($cellData){
            $excel->sheet('score', function($sheet) use ($cellData){
                $sheet->rows($cellData);
            });
        })->store('xls', public_path('excel/exports'));//export('csv');

        $file = public_path('excel\exports\学生成绩.xls');
        // echo $file;
 
        return response()->download($file);

    }





}