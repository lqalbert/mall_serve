<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\OrderBasic;

class SalesPerformanceController extends Controller
{
    //
    public function index(Request $request){
        $start = $request->input('start')." 00:00:00"; //'2018-01-01 00:00:00';
        $end = $request->input('end')." 23:59:59"; //'2018-02-02 23:59:59';
        $groupBy = $request->input('type');
        $pageSize = $request->input('pageSize', 20);
        $offset = ($request->input('page',1) -1) * $pageSize;

        $orderField = $request->input('orderField','cus_count');
        $orderWay  = $request->input('orderWay','desc');

        $where = [];
        $where[]=['db.created_at','>=', $start];
        $where[]=['db.created_at','<=', $end];
        if($request->has('department_id')){
            $where[]=['db.department_id','=', $request->input('department_id')];
        }
        if($request->has('group_id')){
            $where[]=['db.group_id','=', $request->input('group_id')];
        }
//        if($request->input($groupBy)){
//            $where[]=['db.'.$groupBy,'=', $request->input($groupBy)];
//        }
        //退款尝试用子查询 如果加 group_id = x  department_id=y 这种可能会更快
        $refundQuery = DB::table('order_after as oa')
            ->join('order_basic as ob','oa.order_id','=', 'ob.id')
            ->select('oa.fee',"ob.{$groupBy} as map_key")
            ->where([
                ['oa.created_at', '>=', $start],
                ['oa.created_at', '<=', $end],
                ['oa.status','>=',1]
            ]);

        $builder = DB::table('order_basic as db')
            ->select(
                DB::raw('count(distinct db.cus_id) as cus_count'),
                DB::raw('count(db.id) as c_cus_count'),
                DB::raw('sum(order_all_money) as all_pay'), //排除了 内部订单就正确
                DB::raw('IFNULL(sum(oa.fee),0) as refund'),
                DB::raw('IFNULL(sum(freight),0) as s_freight'),
                'db.user_name',
                'db.group_name',
                'db.department_name',
                'db.department_id',
                'db.group_id',
                'db.user_id'
            )
            //如果 一个订单有多个 order_after 就会造成 DB::raw(count, sum) 重复计算,而且也是不 时间段内的退款，而是指定时间段内订单的退款
            ->leftJoin(DB::raw("({$refundQuery->toSql()}) as oa"), "db.{$groupBy}",'=','oa.map_key')->mergeBindings($refundQuery)
            ->where($where)
            ->where([
                ['db.status','>', OrderBasic::UN_CHECKED],
                ['db.status','<', OrderBasic::ORDER_STATUS_7],
                ['db.type','<>', 2]
            ])
            ->groupBy('db.'.$groupBy);

        if ($groupBy == 'department_id') {
            $builder->join('department_basic','db.department_id','=','department_basic.id')->addSelect('deposit');
        }
        //生成内部订单的 内购单数 内购金额
        $where2 = [];
        $where2[]=['db2.created_at','>=', $start];
        $where2[]=['db2.created_at','<=', $end];
        if($request->has('department_id')){
            $where2[]=['db2.department_id','=', $request->input('department_id')];
        }
        if($request->has('group_id')){
            $where2[]=['db2.group_id','=', $request->input('group_id')];
        }
        $builder2 = DB::table('order_basic as db2')
                       ->select(
                           DB::raw('count(db2.id) as inner_count'), 
                           DB::raw('IFNULL(sum(discounted_goods_money),0) as inner_sum'), 
                           DB::raw('IFNULL(sum(freight), 0) as i_freight'),
                           "db2.{$groupBy}")
                       ->where($where2)
                       ->where([
                           ['db2.status','>', OrderBasic::UN_CHECKED],
                           ['db2.status','<', OrderBasic::ORDER_STATUS_7],
                           ['db2.type','=', 1] //这种硬编码其实不好
                       ])->groupBy('db2.'.$groupBy);
                       
        $allBuilder = DB::table(DB::raw("({$builder->toSql()}) as re1"))->select("*")
                          ->mergeBindings($builder)
                          ->leftJoin(DB::raw("({$builder2->toSql()}) as re2"), "re1.{$groupBy}",'=', "re2.{$groupBy}")
                          ->mergeBindings($builder2)
                          ->orderBy($orderField, $orderWay);
        
        
        $result = $allBuilder->paginate($pageSize);
        $items = $result->getCollection();

        return [
            'items'=> $items,
            'total'=> $result->total()
        ];
    }



    public function selectOrder(Request $request){
        //        var_dump($request->all());die;
        $start = $request->input('start')." 00:00:00"; //'2018-01-01 00:00:00';
        $end = $request->input('end')." 23:59:59"; //'2018-02-02 23:59:59';
        $groupBy = $request->input('type');
        $orderType = $request->input('orderType',2);//订单类型 1商城 2内部 3销售
        $pageSize = $request->input('pageSize', 15);
        $offset = ($request->input('page',1) -1) * $pageSize;
        $where = [];
        $where[]=['db.created_at','>=', $start];
        $where[]=['db.created_at','<=', $end];
        //        if($request->has('department_id')){
        //            $where[]=['db.department_id','=', $request->input('department_id')];
        //        }
        //        if($request->has('group_id')){
        //            $where[]=['db.group_id','=', $request->input('group_id')];
        //        }
        if($request->input($groupBy)){
            $where[]=['db.'.$groupBy,'=', $request->input($groupBy)];
        }
        $result = DB::table('order_basic as db')
        ->select(
            'db.order_all_money as trade_money',
            'db.freight',
            'db.user_name as track_name',
            'db.created_at as traded_at',
            'db.order_sn',
            'customer_basic.name as cus_name',
            'order_address.phone as cus_phone'
            )
            ->leftJoin('order_after','db.id','=','order_after.order_id')
            ->leftJoin('customer_basic','customer_basic.id','=','db.cus_id')
            //            ->leftJoin('customer_contact','customer_contact.cus_id','=','db.cus_id')
        ->leftJoin('order_address','order_address.order_id','=','db.id')
        ->where($where)
        ->where([
            ['db.status','>', OrderBasic::UN_CHECKED],
            ['db.status','<', OrderBasic::ORDER_STATUS_7],
            ['db.type','=', $orderType] //内部订单不统计在里面
        ])
        ->paginate($pageSize);
        return [
            'items'=>$result->getCollection(),
            'total'=>$result->total()
        ];
    }

    public function setTrans($groupBy, $keyValue, $start, $end, $items)
    {
        //退款金额
        $userInSubQuery= DB::table('order_after as a')
            ->join('order_basic as db','a.order_id','=','db.id')
            ->where([
                ['a.created_at','>=',$start],
                ['a.created_at','<=',$end],
                ['a.status','=',1]
            ])->select(DB::raw("sum(a.fee) as fee"),"db.{$groupBy} as map_key")->groupby('db.'.$groupBy);
        $inResult = $userInSubQuery->get();
        if (!$inResult->isEmpty()) {
            $inMap = $inResult->mapWithKeys(function($item){
                return [$item->map_key => $item->fee];
            });
        } else {
            $inMap = collect();
        }
        $items->each(function($itm) use($inMap, $groupBy){
            if (!$inMap->isEmpty()) {
                $itm->refund=  $inMap->has($itm->{$groupBy}) ? $inMap->get($itm->{$groupBy}) : 0;
            } else {
                $itm->refund="0";
            }

        });
    }
}
