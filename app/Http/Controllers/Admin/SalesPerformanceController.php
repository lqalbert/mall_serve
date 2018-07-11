<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $builder = DB::table('order_basic as db')
            ->select(
                DB::raw('count(distinct db.cus_id) as cus_count'),
                DB::raw('count(db.id) as c_cus_count'),
                DB::raw('sum(order_all_money) as all_pay'),
                DB::raw('sum(order_after.fee) as refund'),
                'db.user_name',
                'db.group_name',
                'db.department_name',
                'db.department_id',
                'db.group_id'
            )
            ->leftJoin('order_after','db.id','=','order_after.order_id')
            ->where($where)->groupBy('db.'.$groupBy);
        
        if ($groupBy == 'department_id') {
            $builder->join('department_basic','db.department_id','=','department_basic.id')->addSelect('deposit');
        }  
            
        $result = $builder-> paginate($pageSize);
            
        return [
            'items'=>$result->items(),
            'total'=>$result->total()
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
            ->where($where)->paginate($pageSize);
        return [
            'items'=>$result->items(),
            'total'=>$result->total()
        ];
    }
}
