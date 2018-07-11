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
        $where = [];
        $where1 = [];
        $where[]=['order_basic.created_at','>=', $start];
        $where[]=['order_basic.created_at','<=', $end];
        $where1[]=['order_after.created_at','>=', $start];
        $where1[]=['order_after.created_at','<=', $end];
        $where1[]=['order_after.status','=', 1];
        if($request->has('department_id')){
            $where[]=['order_basic.department_id','=', $request->input('department_id')];
        }
        if($request->has('group_id')){
            $where[]=['order_basic.group_id','=', $request->input('group_id')];
        }
        //获取满足查询条件的退款金
        $refunds = OrderBasic::select(
                DB::raw('sum(order_after.fee) as refund'),
                'order_basic.department_id',
                'order_basic.group_id',
                'order_basic.user_id'
            )
            ->leftJoin('order_after','order_basic.id','=','order_after.order_id')
            ->where($where1)->groupBy('order_basic.'.$groupBy)->get()->toArray();
//        if($request->input($groupBy)){
//            $where[]=['db.'.$groupBy,'=', $request->input($groupBy)];
//        }
        $builder = OrderBasic::select(
                DB::raw('count(distinct order_basic.cus_id) as cus_count'),
                DB::raw('count(order_basic.id) as c_cus_count'),
                DB::raw('sum(order_all_money) as all_pay'),
                'order_basic.user_name',
                'order_basic.group_name',
                'order_basic.department_name',
                'order_basic.department_id',
                'order_basic.group_id',
                'order_basic.user_id'
            )
            ->where($where)
            ->whereNotIn('order_basic.status',[OrderBasic::ORDER_STATUS_7,OrderBasic::ORDER_STATUS_8])
            ->groupBy('order_basic.'.$groupBy);
        
        if ($groupBy == 'department_id') {
            $builder->join('department_basic','order_basic.department_id','=','department_basic.id')->addSelect('deposit');
        }
        $result = $builder-> paginate($pageSize)->toArray();
        $result = $result['data'];

        foreach ($result as $k1=>$v1){
            foreach ($refunds as $k2=>$v2){
                if($groupBy=='department_id' && ($v1['department_id'] == $v2['department_id'])){
                    $result[$k1]['refund'] = $v2['refund'];
                }
                if($groupBy=='group_id' && ($v1['group_id'] == $v2['group_id'])){
                    $result[$k1]['refund'] = $v2['refund'];
                }
            }
        }
//        return [
//            'items'=>$result->items(),
//            'total'=>$result->total()
//        ];
        return [
            'items'=>$result,
            'total'=>count($result)
        ];
    }



    public function selectOrder(Request $request){
        $start = $request->input('start')." 00:00:00"; //'2018-01-01 00:00:00';
        $end = $request->input('end')." 23:59:59"; //'2018-02-02 23:59:59';
        $groupBy = $request->input('type');
        $pageSize = $request->input('pageSize', 20);
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
            ->whereNotIn('db.status',[OrderBasic::ORDER_STATUS_7,OrderBasic::ORDER_STATUS_8])
            ->paginate($pageSize);
        return [
            'items'=>$result->items(),
            'total'=>$result->total()
        ];
    }
}
