<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\OrderType;
use App\Models\OrderBasic;

class SalesPerformanceController extends Controller
{
    public function index(Request $request)
    {
        $start = $request->input('start')." 00:00:00"; //'2018-01-01 00:00:00';
        $end = $request->input('end')." 23:59:59"; //'2018-02-02 23:59:59';
        $groupBy = $request->input('type');
        $pageSize = $request->input('pageSize', 20);
        $offset = ($request->input('page',1) -1) * $pageSize;
        
        $orderField = $request->input('orderField','cus_count');
        $orderWay  = $request->input('orderWay','desc');
        
        if($request->has('department_id')){
            
        }
        if($request->has('group_id')){
            
        }
        
        $innerOrderType = OrderType::where('name', OrderType::INNER_NAME)->first();
        $saleOrderType = OrderType::where('name', OrderType::SALE_NAME)->first();
        
        $mainBuilder = $this->getMainBuilder($groupBy, $request);
        
        $innermallOrderBuilder = $this->getMallOrderStuff($groupBy, $start, $end, $innerOrderType->id, $request);
        $salemallOrderBuilder = $this->getMallOrderStuff($groupBy, $start, $end, $saleOrderType->id, $request);
        $jdOrderBuilder = $this->getJdOrderStuff($groupBy, $start, $end, $request);
        $refundBuilder = $this->getRefundStuff($groupBy, $start, $end, $request);
        $appendBuilder = $this->getAppendStuff($groupBy, $start, $end, $request);
        
        
        $allBuilder = DB::table(DB::raw("({$mainBuilder->toSql()}) as main_re"))
        ->select(DB::raw('main_re.*'), 
            'sale_order.cus_count as sale_cus_count', 
            'sale_order.order_sum as all_pay2', // 销售金额
            'sale_order.order_count as all_sale_count',// all_sale_count 成交单数
            'sale_order.freight as sale_freight',
            'sale_order.book_freight as sale_book_freight',
            'inner_order.cus_count as inner_count', //内购单数
            'inner_order.order_sum as inner_sum', //内购金额
            'inner_order.freight as inner_freight',
            'inner_order.book_freight as inner_book_freight',
            DB::raw("(IFNULL(sale_order.freight,0)  + IFNULL(inner_order.freight,0)) as i_freight"),
            DB::raw("(IFNULL(sale_order.book_freight,0) + IFNULL(inner_order.book_freight,0)) as b_freight"),
            DB::raw("(IFNULL(sale_order.cus_count,0) + IFNULL(inner_order.cus_count,0))  as out_cus_cout" ), //成交客户数
            DB::raw('IFNULL(jd_order.jd_count,0) as jd_count'),
            DB::raw('IFNULL(jd_order.jd_sum,0) as jd_sum'),
            DB::raw('IFNULL(refund_.refund_fee,0) as refund2'),
            DB::raw('IFNULL(append_.append_sum,0) as append_sum')
            )
        ->mergeBindings($mainBuilder)
        //销售
        ->leftJoin(DB::raw("({$salemallOrderBuilder->toSql()}) as sale_order"), "main_re.{$groupBy}",'=', "sale_order.{$groupBy}")
        ->mergeBindings($salemallOrderBuilder)
        //内购
        ->leftJoin(DB::raw("({$innermallOrderBuilder->toSql()}) as inner_order"), "main_re.{$groupBy}",'=', "inner_order.{$groupBy}")
        ->mergeBindings($innermallOrderBuilder)
        //京东
        ->leftJoin(DB::raw("({$jdOrderBuilder->toSql()}) as jd_order"), "main_re.{$groupBy}",'=', "jd_order.{$groupBy}")
        ->mergeBindings($jdOrderBuilder)
//         //退款
        ->leftJoin(DB::raw("({$refundBuilder->toSql()}) as refund_"), "main_re.{$groupBy}",'=', "refund_.{$groupBy}")
        ->mergeBindings($refundBuilder)
//         //赠品
        ->leftJoin(DB::raw("({$appendBuilder->toSql()}) as  append_"), "main_re.{$groupBy}",'=', "append_.{$groupBy}")
        ->mergeBindings($appendBuilder)
        ;
        
        $result = $allBuilder->paginate($pageSize);
        $items = $result->getCollection();
        
        return [
            'items'=> $items,
            'total'=> $result->total()
        ];
        
    }
        
    private function getMainBuilder($groupBy, $request)
    {
        $builder = null;
        switch ($groupBy) {
            case 'user_id':
                $builder = DB::table('user_basic as ub')
                           ->select('ub.id as user_id', 'ub.realname as user_name','gb.name as group_name', 'db.name as department_name')
                           ->join('group_basic as gb', 'ub.group_id','=','gb.id')
                           ->leftJoin('department_basic as db', 'ub.department_id','=','db.id')
                           ->whereNull('ub.deleted_at')
                           ->whereNull('gb.deleted_at')
                           ->whereNull('db.deleted_at');
               
                break;
            case 'group_id';
                $builder = DB::table('group_basic as gb')
                            ->select('gb.id as group_id', 'gb.name as group_name', 'db.name as department_name')
                            ->leftJoin('department_basic as db', 'gb.department_id','=','db.id')
                            ->whereNull('gb.deleted_at')
                            ->whereNull('db.deleted_at');
                
                break;
            case 'department_id':
            default:
                $builder = DB::table('department_basic as db')
                            ->select('db.id as department_id', 'db.name as department_name', 'db.deposit')
                            ->whereNull('db.deleted_at');
                
                break;
        }
        
        if ($request->has('group_id')) {
            $builder  = $builder->where('gb.id', $request->input('group_id'));
        }
        if ($request->has('department_id')) {
            $builder  = $builder->where('db.id', $request->input('department_id'));
        }

        return $builder;
    }
    
    private function getMallOrderStuff($groupBy, $start, $end, $types, $request)
    {
        $builder = DB::table('order_basic as ob')
        ->select(
            DB::raw('count(distinct cus_id) as cus_count'),
            DB::raw('sum(discounted_goods_money) as order_sum'), 
            DB::raw('count(ob.id) as order_count'),
            DB::raw('sum(freight) as freight'),
            DB::raw('sum(book_freight) as book_freight'),
            $groupBy,
            'type');

        if($request->has('department_id')){
            $builder = $builder->where('ob.department_id', $request->input('department_id'));
        }
        if($request->has('group_id')){
            $builder = $builder->where('ob.group_id', $request->input('group_id'));
        }
        
        $builder =$builder ->where([
            ['ob.created_at','>=', $start],
            ['ob.created_at','<=', $end],
            ['ob.status','>', OrderBasic::UN_CHECKED],
            ['ob.status','<', OrderBasic::ORDER_STATUS_7]
        ])->whereNull('ob.deleted_at')
        ->where('type', $types)
        ->groupBy($groupBy);
        
        return $builder;
    }
    
    private function getJdOrderStuff($groupBy, $start, $end, $request)
    {
        $builder = DB::table('jd_order_basic')->select(
                        DB::raw('count(id) as jd_count'),
                        DB::raw('sum(all_money) as jd_sum'),
                        $groupBy
                    )
                   ->where([
                       ['order_at', '>=', $start],
                       ['order_at', '<=', $end]
                   ])->groupBy($groupBy);
        
                   
                   
       if($request->has('department_id')){
           $builder = $builder->where('jd_order_basic.department_id', $request->input('department_id'));
       }
       if($request->has('group_id')){
           $builder = $builder->where('jd_order_basic.group_id', $request->input('group_id'));
       }
        return $builder;
    }
    
    private function getRefundStuff($groupBy, $start, $end)
    {
        $refundQuery = DB::table('order_after as oa')
        ->join('order_basic as ob','oa.order_id','=', 'ob.id')
        ->select(DB::raw('sum(oa.fee) as refund_fee'),"ob.{$groupBy}")
        ->where([
            ['oa.created_at', '>=', $start],
            ['oa.created_at', '<=', $end],
            ['oa.status','>=',1]
        ])->groupBy('ob.'.$groupBy);
        return $refundQuery;
    }
    //赠品
    private function getAppendStuff($groupBy, $start, $end, $request)
    {
        $appendBuilder = DB::table('order_goods as og')
                         ->select(
                                DB::raw('sum(og.price * og.goods_number) as append_sum'),
                                'ob1.'.$groupBy
                             )
                         ->join('order_basic as ob1','og.order_id','=','ob1.id')
                         ->where('og.sale_type','1')
                         ->where([
                             ['ob1.created_at','>=', $start],
                             ['ob1.created_at','<=', $end],
                             ['ob1.status','>', OrderBasic::UN_CHECKED],
                             ['ob1.status','<', OrderBasic::ORDER_STATUS_7]
                         ])->whereNull('ob1.deleted_at')
                         ->groupBy('ob1.'.$groupBy);
         if($request->has('department_id')){
             $appendBuilder= $appendBuilder->where('ob1.department_id', $request->input('department_id'));
         }
         if($request->has('group_id')){
             $appendBuilder= $appendBuilder->where('ob1.group_id', $request->input('group_id'));
         }
         
         return $appendBuilder;
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
        
        if($request->has('department_id')){
            $where[]=['db.department_id','=', $request->input('department_id')];
        }
        if($request->has('group_id')){
            $where[]=['db.group_id','=', $request->input('group_id')];
        }
        if($request->has('user_id')){
            $where[]=['db.user_id','=', $request->input('user_id')];
        }
        // if($request->input($groupBy)){
        //     $where[]=['db.'.$groupBy,'=', $request->input($groupBy)];
        // }
        
        $result = DB::table('order_basic as db')
        ->select(
            'db.discounted_goods_money as trade_money',
            'db.freight',
            'db.user_name as track_name',
            'db.created_at as traded_at',
            'db.order_sn',
            'customer_basic.name as cus_name',
            'order_address.phone as cus_phone',
            'order_address.fixed_telephone as telephone'
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
        ])->paginate($pageSize);//->groupBy('db.'.$groupBy)
        
        return [
            'items'=>$result->getCollection(),
            'total'=>$result->total()
        ];
    }
    
}
