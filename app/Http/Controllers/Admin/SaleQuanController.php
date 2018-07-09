<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class SaleQuanController extends Controller
{
    public function index(Request $request)
    {
        $start = $request->input('start')." 00:00:00"; //'2018-01-01 00:00:00';
        $end = $request->input('end')." 23:59:59"; //'2018-02-02 23:59:59';
        $groupBy = $request->input('type');
        $pageSize = $request->input('pageSize', 20);
        $offset = ($request->input('page',1) -1) * $pageSize;
        
//         DB::select('select sum(a.id) as cus_count from customer_basic as a where  created_at >= :start and ', ['start' => $start, 'end'=>$end]);
        //不能连接，只能单独查询
        //转进来的
        $userInSubQuery= DB::connection('mysql_read')->table('customer_user as a')->join('customer_user as b','a.cus_id','=','b.cus_id')
        ->whereIn('b.type',[1,2])
        ->where([
            ['b.created_at','>=',$start],
            ['b.created_at','<=',$end],
            ['a.'.$groupBy,'!=','b.'.$groupBy]
        ])->select('b.id','b.cus_id','b.user_id','b.group_id','b.department_id');
        logger('[subquery1]', [$userInSubQuery->toSql()]);
        //不能连接，只能单独查询
        //转出去的
        $userOutSubQuery= DB::connection('mysql_read')->table('customer_user as a')->join('customer_user as b', 'a.cus_id','=','b.cus_id')
        ->whereIn('b.type',[1,2])
        ->where([
            ['a.deleted_at','>=',$start],
            ['a.deleted_at','<=',$end],
            ['a.'.$groupBy,'!=','b.'.$groupBy]
        ])
        ->select('a.id','a.cus_id','a.user_id','a.group_id','a.department_id');
        logger('[subquery2]', [$userOutSubQuery->toSql()]);
        //录入数, 成交客户数
        
        
        $result = DB::connection('mysql_read')->table('customer_basic as cus_a')
        ->select(
            DB::raw('count(cus_a.id) as cus_count'), 
            DB::raw('count(c_cus.id) as c_cus_count'),
            DB::raw('count(b_cus.id) as b_cus_count'), 
            DB::raw('count(user_track.id) as track_count')
           // DB::raw('count(user_in.id) as user_in_count'),
            //DB::raw('count(user_out.id) as user_out_count')
            )
        ->addSelect(DB::raw('count(ob.id) as ob_count, count(distinct ob.cus_id) as obcus_count'))
        ->addSelect('owner.department_name','owner.group_name','owner.user_name')
        ->join('customer_user as owner','cus_a.id','=','owner.cus_id')
        ->leftJoin('order_basic as ob','cus_a.id','=','ob.cus_id')
        ->join('customer_basic as c_cus', function($join){ // c 类型
            $join->on('cus_a.id','=','c_cus.id')
                ->where('c_cus.type','=','C');
        },null,null,'left')
        ->join('customer_basic as b_cus', function($join){ // b 类型
            $join->on('cus_a.id','=','b_cus.id')
                 ->where('b_cus.type','=','B');
        },null, null, 'left')
        ->join('customer_user as user_track', function($join){ //跟踪数
            $join->on('owner.id','=','user_track.id')
                ->whereNotNull('user_track.last_track');
        },null,null,'left')
//         ->from(DB::raw("({$userInSubQuery->toSql()}) as user_in"))
        //->from("({$userOutSubQuery->toSql()}) as user_out")
        ->where('owner.type',0)
        ->where([
            ['cus_a.created_at','>=',$start],
            ['cus_a.created_at','<=',$end]  
        ])
//         ->where('user_in.'.$groupBy,'=','owner.'.$groupBy)
        //->where('user_out.'.$groupBy,'=','owner.'.$groupBy)
        ->whereNull('cus_a.deleted_at')
        ->whereNull('owner.deleted_at')
//         ->mergeBindings($userInSubQuery)
        //->mergeBindings($userOutSubQuery->getQuery())
        ->groupBy('owner.'.$groupBy)
        ->offset($offset)
        ->limit($pageSize)
        ->get();
        
        
        return [
            'items'=> $result,
            'total'=>0
        ];
    }
    
    /**
     * 例子
     */
    public function saleIndex()
    {
        $start = "";
        $end = "";
        $result = DB::table('order_basic as db')
        ->select(
            DB::raw('count(distinct db.cus_id) as cus_count'),
            DB::raw('count(db.id) as c_cus_count'),
            DB::raw('sum(order_all_money) as all_pay'),
            DB::raw('sum(order_after.fee) as refund'),
            'db.user_name',
            'db.group_name',
            'db.department_name'
            )
        ->leftJoin('order_after','db.id','=','order_after.order_id')
        ->where([
            ['db.created_at','>=', $start],
            ['db.created_at','<=', $end],
        ])->groupBy('db.user_id')->get();
        
        return [
            'items'=>$result,
            'total'=>0
        ];
    }
}
