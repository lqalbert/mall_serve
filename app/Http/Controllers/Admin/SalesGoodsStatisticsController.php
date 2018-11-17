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
        // var_dump($request->end);die();
        $start = $request->input('start')." 00:00:00";
        $end = $request->input('end')." 23:59:59";
        $pageSize = $request->input('pageSize', 15);
        $orderField = $request->input('orderField','produce_in_total');
        $orderWay  = $request->input('orderWay','desc');
        $where = [
            // ['cb.created_at','>=',$start],
            // ['cb.created_at','<=',$end],
        ];
        // if($request->has('goods_name')){
        //     $where[] = ['goods_name','like',$request->input('goods_name')."%"];
        // }

        $inventoryBuilder = $this->inInventory($start, $end);
        $saleBuilder = $this->saleNUm($start, $end);
        $innerSaleBuilder = $this->innerSaleNum($start, $end);
//         $shopSaleBuilder = $this->shopSaleNum($start, $end);
        $refundBuilder = $this->refundNum($start, $end);
        $sampleBuilder = $this->sampleNum($start, $end);
        $saleMoneyBuilder = $this->saleMoney($start, $end);
        $innerSaleMoneyBuilder = $this->innerSaleMoney($start, $end);
//         $shopSaleMoneyBuilder = $this->shopSaleMoney($start, $end);
        $sampleSaleMoneyBuilder = $this->sampleSaleMoney($start, $end);
        $destroyCount = $this->destroyCount($start, $end);
        $jdBuilder = $this->getJdOrderStuff($start, $end);

        $result = DB::table('inventory_system as iso')->select(
                        'iso.sku_sn','iso.goods_name',
                        DB::raw('iso.produce_in as produce_in_total'),
                        DB::raw('iso.entrepot_count as saleable_count'),
                        DB::raw('sale.goods_num as sale_num'),
                        DB::raw("inven.goods_num as invent_num"),
                        DB::raw('inner_sale.goods_num as inner_num'),
                        DB::raw('jd.goods_num as shop_num'),
                        DB::raw('sample.goods_num as sample_num'),
                        DB::raw('refu.goods_num as ref_num'),
                        // DB::raw('inven.goods_num as invent_num'),
                        DB::raw('sm.money as sale_money'),
                        DB::raw('ism.money*0.6 as inner_sale_money'),
                        DB::raw('jd.money as shop_sale_money'),
                        DB::raw('spsm.money as sample_sale_money'),
                        DB::raw('dc.destroyNum as destroy_count')
                    )
                    ->leftJoin(DB::raw("({$inventoryBuilder->toSql()}) as inven"),'iso.sku_sn','=','inven.sku_sn')
                    ->mergeBindings($inventoryBuilder)
                    ->leftJoin(DB::raw("({$saleBuilder->toSql()}) as sale"), 'iso.sku_sn','=','sale.sku_sn')
                    ->mergeBindings($saleBuilder)
                    ->leftJoin(DB::raw("({$innerSaleBuilder->toSql()}) as inner_sale"),'iso.sku_sn','=','inner_sale.sku_sn')
                    ->mergeBindings($innerSaleBuilder)
//                     ->leftJoin(DB::raw("({$shopSaleBuilder->toSql()}) as shop_sale"),'iso.sku_sn','=','shop_sale.sku_sn')
//                     ->mergeBindings($shopSaleBuilder)
                    ->leftJoin(DB::raw("({$refundBuilder->toSql()}) as refu"),'iso.sku_sn','=','refu.sku_sn')
                    ->mergeBindings($refundBuilder)
                    ->leftJoin(DB::raw("({$sampleBuilder->toSql()}) as sample"), 'iso.sku_sn','=','sample.sku_sn')
                    ->mergeBindings($sampleBuilder)
                    ->leftJoin(DB::raw("({$saleMoneyBuilder->toSql()}) as sm"),'iso.sku_sn','=','sm.sku_sn')
                    ->mergeBindings($saleMoneyBuilder)
                    ->leftJoin(DB::raw("({$innerSaleMoneyBuilder->toSql()}) as ism"),'iso.sku_sn','=','ism.sku_sn')
                    ->mergeBindings($innerSaleMoneyBuilder)
//                     ->leftJoin(DB::raw("({$shopSaleMoneyBuilder->toSql()}) as ssm"),'iso.sku_sn','=','ssm.sku_sn')
//                     ->mergeBindings($shopSaleMoneyBuilder)
                    ->leftJoin(DB::raw("({$sampleSaleMoneyBuilder->toSql()}) as spsm"),'iso.sku_sn','=','spsm.sku_sn')
                    ->mergeBindings($sampleSaleMoneyBuilder)
                    ->leftJoin(DB::raw("({$destroyCount->toSql()}) as dc"),'iso.sku_sn','=','dc.sku_sn')
                    ->mergeBindings($destroyCount)
                    ->leftJoin(DB::raw("({$jdBuilder->toSql()}) as jd"), 'iso.sku_sn','=','jd.sku_sn')
                    ->mergeBindings($jdBuilder)
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
        return DB::table('actual_delivery_goods')->select(
            DB::raw("sum(`actual_goods_num`) as goods_num"),
            'sku_sn')
        // ->where([
        //     ['created_at',">=", $start],
        //     ['created_at',"<=", $end]
        // ])
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
        ])->whereNull('order_basic.deleted_at')
        ->whereNull('order_goods.deleted_at')
        ->groupBy('sku_sn');
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
            ])
            ->whereNull('order_basic.deleted_at')
            ->whereNull('order_goods.deleted_at')
            ->groupBy('sku_sn');
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
            ])
            ->whereNull('order_basic.deleted_at')
            ->whereNull('order_goods.deleted_at')
            ->groupBy('sku_sn');
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
            ])
            ->whereNull('order_basic.deleted_at')
            ->whereNull('order_goods.deleted_at')
            ->groupBy('sku_sn');
    }
    
    /**
     * 京东订单  原来的作废
     * @param unknown $groupBy
     * @param unknown $start
     * @param unknown $end
     * @param unknown $request
     * @return unknown
     */
    private function getJdOrderStuff($start, $end)
    {
        $builder = DB::table('jd_order_basic')
                   ->join('jd_order_goods','jd_order_basic.order_sn','=','jd_order_goods.order_sn')
                   ->select(DB::raw('sum(goods_num) as goods_num'),
                       DB::raw('sum(goods_num* goods_price) as money'),
                       'sku_sn')
                   ->where([
                       ['order_at', '>=', $start],
                       ['order_at', '<=', $end]
                   ])->whereNull('jd_order_basic.deleted_at')
                   ->whereNull('jd_order_goods.deleted_at')
                   ->groupBy('sku_sn');
        
        return $builder;
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
            ])
            ->whereNull('order_basic.deleted_at')
            ->whereNull('order_goods.deleted_at')
            ->groupBy('sku_sn');
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
            ])
            ->whereNull('order_basic.deleted_at')
            ->whereNull('order_goods.deleted_at')
            ->groupBy('sku_sn');
    }
    
    private function refundNum($start, $end)
    {
        return DB::table('order_after')->select(
            DB::raw("sum(`goods_number`) as goods_num"),
            'sku_sn'
            )
            ->join('order_goods','order_after.order_id','=','order_goods.order_id')
            ->where([
                // ['order_basic.status','>=',1],
                // ['order_basic.status','<=',6],
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
    /**
     * [destroyCount 损坏数]
     * @param  [type] $start [description]
     * @param  [type] $end   [description]
     * @return [type]        [description]
     */
    private function destroyCount($start,$end){
        return DB::table('order_goods')->select(
                DB::raw("sum(`destroy_num`) as destroyNum"),'sku_sn')
            ->where([
                ['order_goods.destroy_time',">=", $start],
                ['order_goods.destroy_time',"<=", $end],
            ])->groupBy('sku_sn');
    }

//******************************************以下为部门的**************************************************************
    public function getDepSaleGoods(Request $request,$sku){
        $start = $request->input('start')." 00:00:00";
        $end = $request->input('end')." 23:59:59";
        $orderField = $request->input('orderField','sale_num');
        $orderWay = $request->input('orderWay','desc');

        $depSaleBuilder = $this->depSaleNUm($sku,$start,$end);
        $depSaleMoneyBuilder = $this->depSaleMoney($sku,$start, $end);
        $depInnerSaleBuilder = $this->depInnerSaleNum($sku,$start, $end);
        $depInnerSaleMoneyBuilder = $this->depInnerSaleMoney($sku,$start, $end);
//         $depShopSaleBuilder = $this->depShopSaleNum($sku,$start, $end);
//         $depShopSaleMoneyBuilder = $this->depShopSaleMoney($sku,$start, $end);
        $depRefundBuilder = $this->depRefundNum($sku,$start, $end);
        $depSampleBuilder = $this->depSampleNum($sku,$start, $end);
        $depSampleMoneyBuilder = $this->depSampleMoney($sku,$start, $end);
        $depDestroyCountBuilder = $this->depDestroyCount($sku,$start, $end);
        $jdOrderBuilder = $this->getJdOrderDepartment($sku,$start, $end);

        $result = DB::table('department_basic as db')->select(
                'db.manager_id',
                DB::raw("db.name as department_name"),
                DB::raw("ub.realname as department_manager"),
                DB::raw('ds.goods_num as sale_num'),
                DB::raw('dis.goods_num as inner_num'),
                DB::raw('jd.goods_num as shop_num'),
                DB::raw('dsp.goods_num as sample_num'),
                DB::raw('drf.goods_num as ref_num'),
                DB::raw('ddc.destroyNum as destroy_count'),
                DB::raw('dsm.money as sale_money'),
                DB::raw('dism.money*0.6 as inner_sale_money'),
                DB::raw('jd.money as shop_sale_money'),
                DB::raw('dspm.money as sample_sale_money')

            )->join('user_basic as ub','db.manager_id','=','ub.id')
            ->leftJoin(DB::raw("({$depSaleBuilder->toSql()}) as ds"),'db.id','=','ds.department_id')
            ->mergeBindings($depSaleBuilder)
            ->leftJoin(DB::raw("({$depSaleMoneyBuilder->toSql()}) as dsm"),'db.id','=','dsm.department_id')
            ->mergeBindings($depSaleMoneyBuilder)
            ->leftJoin(DB::raw("({$depInnerSaleBuilder->toSql()}) as dis"),'db.id','=','dis.department_id')
            ->mergeBindings($depInnerSaleBuilder)
            ->leftJoin(DB::raw("({$depInnerSaleMoneyBuilder->toSql()}) as dism"),'db.id','=','dism.department_id')
            ->mergeBindings($depInnerSaleMoneyBuilder)
//             ->leftJoin(DB::raw("({$depShopSaleBuilder->toSql()}) as dss"),'db.id','=','dss.department_id')
//             ->mergeBindings($depShopSaleBuilder)
//             ->leftJoin(DB::raw("({$depShopSaleMoneyBuilder->toSql()}) as dssm"),'db.id','=','dssm.department_id')
//             ->mergeBindings($depShopSaleMoneyBuilder)
            ->leftJoin(DB::raw("({$depRefundBuilder->toSql()}) as drf"),'db.id','=','drf.department_id')
            ->mergeBindings($depRefundBuilder)
            ->leftJoin(DB::raw("({$depSampleBuilder->toSql()}) as dsp"),'db.id','=','dsp.department_id')
            ->mergeBindings($depSampleBuilder)
            ->leftJoin(DB::raw("({$depSampleMoneyBuilder->toSql()}) as dspm"),'db.id','=','dspm.department_id')
            ->mergeBindings($depSampleMoneyBuilder)
            ->leftJoin(DB::raw("({$depDestroyCountBuilder->toSql()}) as ddc"),'db.id','=','ddc.department_id')
            ->mergeBindings($depDestroyCountBuilder)
            ->leftJoin(DB::raw("({$jdOrderBuilder->toSql()}) as jd"),'db.id','=','jd.department_id')
            ->mergeBindings($jdOrderBuilder)
            ->where([
                ['db.type',0]
                // ['db.status',1]
            ])->where(function($query){
                $query->where('ds.goods_num','<>',0)
                      ->orWhere('dis.goods_num','<>',0)
                      ->orWhere('jd.goods_num','<>',0)
                      ->orWhere('dsp.goods_num','<>',0)
                      ->orWhere('drf.goods_num','<>',0)
                      ->orWhere('ddc.destroyNum','<>', 0);
            })->orderBy($orderField,$orderWay)->paginate(100);

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
    private function depSaleNUm($sku,$start,$end)
    {
        $where = [
            ['order_basic.status','>=',1],
            ['order_basic.status','<=',6],
            ['order_basic.type','=',3], //销售订单
            ['order_basic.created_at',">=", $start],
            ['order_basic.created_at',"<=", $end],
            ['order_goods.status','<>',3],
            ['order_goods.sku_sn',$sku]
        ];
        return DB::table('order_basic')->select(
            DB::raw("sum(`goods_number`) as goods_num"),
            'sku_sn','department_id'
            )
        ->join('order_goods','order_basic.id','=','order_goods.order_id')
        ->where($where)
        ->whereNull('order_basic.deleted_at')
        ->whereNull('order_goods.deleted_at')->groupBy('department_id');
    }
    
    /**
     * [saleMoney 销售订单金额]
     * @param  [type] $start [description]
     * @param  [type] $end   [description]
     * @return [type]        [description]
     */
    private function depSaleMoney($sku,$start, $end){
        $where = [
            ['order_basic.status','>=',1],
            ['order_basic.status','<=',6],
            ['order_basic.type','=',3], //销售订单
            ['order_basic.created_at',">=", $start],
            ['order_basic.created_at',"<=", $end],
            ['order_goods.status','<>',3],
            ['order_goods.sku_sn',$sku]
        ];
        return DB::table('order_basic')->select(
                DB::raw("sum(`goods_number`*`price`) as money"),'sku_sn','department_id'
            )->join('order_goods','order_basic.id','=','order_goods.order_id')
            ->where($where)
            ->whereNull('order_basic.deleted_at')
            ->whereNull('order_goods.deleted_at')->groupBy('department_id');
    }

    /**
     * 内部订单
     * @param unknown $start
     * @param unknown $end
     * @return unknown
     */
    private function depInnerSaleNum($sku,$start, $end)
    {
        $where = [
            ['order_basic.status','>=',1],
            ['order_basic.status','<=',6],
            ['order_basic.type','=',2], // 内部的订单
            ['order_basic.created_at',">=", $start],
            ['order_basic.created_at',"<=", $end],
            ['order_goods.status','<>',3],
            ['order_goods.sku_sn',$sku]
        ];
        return DB::table('order_basic')->select(
            DB::raw("sum(`goods_number`) as goods_num"),
            'sku_sn','department_id'
            )
            ->join('order_goods','order_basic.id','=','order_goods.order_id')
            ->where($where)
            ->whereNull('order_basic.deleted_at')
            ->whereNull('order_goods.deleted_at')->groupBy('department_id');
    }

    /**
     * [innerSaleMoney 内购金额]
     * @param  [type] $start [description]
     * @param  [type] $end   [description]
     * @return [type]        [description]
     */
    private function depInnerSaleMoney($sku,$start,$end){
        $where = [
            ['order_basic.status','>=',1],
            ['order_basic.status','<=',6],
            ['order_basic.type','=',2], //销售订单
            ['order_basic.created_at',">=", $start],
            ['order_basic.created_at',"<=", $end],
            ['order_goods.status','<>',3],
            ['order_goods.sku_sn',$sku]
        ];
        return DB::table('order_basic')->select(
                DB::raw("sum(`goods_number`*`price`) as money"),'sku_sn','department_id'
            )->join('order_goods','order_basic.id','=','order_goods.order_id')
            ->where($where)
            ->whereNull('order_basic.deleted_at')
            ->whereNull('order_goods.deleted_at')
            ->groupBy('department_id');
    }
    

    
    
    private function getJdOrderDepartment($sku, $start, $end)
    {
        $builder = DB::table('jd_order_basic')
        ->join('jd_order_goods','jd_order_basic.order_sn','=','jd_order_goods.order_sn')
        ->select(DB::raw('sum(goods_num) as goods_num'),
            DB::raw('sum(goods_num* goods_price) as money'),
            'sku_sn',
            'department_id')
            ->where([
                ['order_at', '>=', $start],
                ['order_at', '<=', $end],
                ['jd_order_goods.sku_sn','=', $sku]
            ])->whereNull('jd_order_basic.deleted_at')
            ->whereNull('jd_order_goods.deleted_at');
            
            
        return $builder;
    }

    private function depShopSaleNum($sku,$start, $end)
    {
        $where = [
            ['order_basic.status','>=',1],
            ['order_basic.status','<=',6],
            ['order_basic.type','=',4], //商城的订单
            ['order_basic.created_at',">=", $start],
            ['order_basic.created_at',"<=", $end],
            ['order_goods.status','<>',3],
            ['order_goods.sku_sn',$sku]
        ];
        return DB::table('order_basic')->select(
            DB::raw("sum(`goods_number`) as goods_num"),
            'sku_sn','department_id'
            )
            ->join('order_goods','order_basic.id','=','order_goods.order_id')
            ->where($where)
            ->whereNull('order_basic.deleted_at')
            ->whereNull('order_goods.deleted_at')->groupBy('department_id');
    }
    
    /**
     * [shopSaleMoney 商城金额]
     * @param  [type] $start [description]
     * @param  [type] $end   [description]
     * @return [type]        [description]
     */
    private function depShopSaleMoney($sku,$start, $end){
        $where = [
            ['order_basic.status','>=',1],
            ['order_basic.status','<=',6],
            ['order_basic.type','=',4], //商城订单
            ['order_basic.created_at',">=", $start],
            ['order_basic.created_at',"<=", $end],
            ['order_goods.status','<>',3],
            ['order_goods.sku_sn',$sku]
        ];
        return DB::table('order_basic')->select(
                DB::raw("sum(`goods_number`*`price`) as money"),'sku_sn','department_id'
            )->join('order_goods','order_basic.id','=','order_goods.order_id')
            ->where($where)
            ->whereNull('order_basic.deleted_at')
            ->whereNull('order_goods.deleted_at')
            ->groupBy('department_id');
    }

    /**
     * [refundNum 退货数量]
     * @param  [type] $start [description]
     * @param  [type] $end   [description]
     * @return [type]        [description]
     */
    private function depRefundNum($sku,$start, $end)
    {
        $where = [
            // ['order_basic.status','>=',1],
            // ['order_basic.status','<=',6],
            ['order_after.created_at',">=", $start],
            ['order_after.created_at',"<=", $end],
            ['order_goods.status','=',1],
            ['order_goods.sku_sn',$sku]
        ];
        return DB::table('order_after')->select(
            DB::raw("sum(`goods_number`) as goods_num"),
            'sku_sn','department_id'
            )
            ->join('order_basic','order_after.order_id','=','order_basic.id')
            ->join('order_goods','order_after.order_id','=','order_goods.order_id')
            ->where($where)->whereNull('order_basic.deleted_at')->groupBy('department_id');
    }

    /**
     * 样品数量
     * @param unknown $start
     * @param unknown $end
     */
    private function depSampleNum($sku,$start, $end) 
    {
        $where = [
            ['sample_basic.check_status',1],
            ['sample_basic.check_time',">=", $start],
            ['sample_basic.check_time',"<=", $end],
            ['sample_goods.sku_sn',$sku]
        ];
        return DB::table('sample_basic')->select(
            DB::raw("sum(`goods_number`) as goods_num"),
            'sku_sn','department_id'
            )
            ->join('sample_goods','sample_basic.id','=','sample_goods.sample_id')
            ->where($where)->groupBy('department_id');
    }

    /**
     * 样品金额
     * @param unknown $start
     * @param unknown $end
     */
    private function depSampleMoney($sku,$start, $end) 
    {
        $where = [
            ['sample_basic.check_status',1],
            ['sample_basic.check_time',">=", $start],
            ['sample_basic.check_time',"<=", $end],
            ['sample_goods.sku_sn',$sku]
        ];
        return DB::table('sample_basic')->select(
            DB::raw("sum(`goods_number`*`price`) as money"),
            'sku_sn','department_id'
            )
            ->join('sample_goods','sample_basic.id','=','sample_goods.sample_id')
            ->where($where)->groupBy('department_id');
    }
    /**
     * [destroyCount 损坏数]
     * @param  [type] $start [description]
     * @param  [type] $end   [description]
     * @return [type]        [description]
     */
    private function depDestroyCount($sku,$start,$end){
        return DB::table('order_goods')->select(
            DB::raw("sum(`destroy_num`) as destroyNum"),'sku_sn','department_id')
            ->join('order_basic','order_basic.id','=','order_goods.order_id')
            ->where([
                ['order_goods.destroy_time',">=", $start],
                ['order_goods.destroy_time',"<=", $end],
                ['order_goods.sku_sn',"=", $sku]
            ])->whereNull('order_basic.deleted_at')->groupBy('department_id');
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
        $goodsData = $this->index($request);
        $start = $request->input('start');
        $end = $request->input('end');

        $arr = [];
        $titleArr = ['商品名称','当前库存量','本次销售数量','本次内购数量','本次商城数量','样品数量','退货数量','损坏数量'];
        $cellData = $goodsData['items'];
        foreach ($cellData as $k => &$value) {
            $value = collect($value)->except([
                'invent_num','sale_money','inner_sale_money',
                'shop_sale_money','sample_sale_money','produce_in_total'])->toArray();
            // $value['destroy_count']="暂无";
            
            $sku = $value['sku_sn'];
            array_push($arr, $value);
            $depGoods = $this->getDepSaleGoods($request,$sku);
            foreach ($depGoods['items'] as $n => &$v) {
                $v = collect($v)->toArray();
                $v = collect($v)->except([
                'manager_id','department_manager','sale_money',
                'inner_sale_money','shop_sale_money','sample_sale_money'])->toArray();

                array_unshift($v,'');
                // array_splice($v,-1,0,['sample_num'=>"暂无"]);
                // $v['destroy_count']="暂无";
                array_push($arr,$v);
            }
            
            unset($v);
        }
        unset($value);

        foreach ($arr as &$val) {
            $val = collect($val)->except(['sku_sn'])->map(function($item,$key){
                if($item === null){
                    return $item = 0;
                }else{
                    return $item;
                }
            })->toArray();
        }
        unset($val);

        array_unshift($arr,$titleArr);
        array_unshift($arr,[$start.'至'.$end."销售商品统计表"]);
        // var_dump($arr);die();
        Excel::create('销售商品统计报表',function($excel) use ($arr){
            $excel->sheet('商品统计', function($sheet) use ($arr){
                $sheet->setStyle(array(
                    'font' => [
                        'name' => '宋体',
                        'size' => 13,
                    ]
                ))->row(1, function ($row) {
                    $row->setFont(['bold' => true]);
                });
                $sheet->mergeCells('A1:H1');
                $sheet->setWidth(array(
                    'A'     =>  15,
                    'B'     =>  15,
                    'C'     =>  15,
                    'D'     =>  15,
                    'E'     =>  15,
                    'F'     =>  15,
                    'G'     =>  15,
                    'H'     =>  15
                ));
                $sheet->row(1, function ($row) {
                    $row->setAlignment('center');
                });
                $sheet->rows($arr);
            });
        })->export('xls');//export('csv');

    }



}
