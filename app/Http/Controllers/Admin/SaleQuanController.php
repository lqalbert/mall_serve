<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class SaleQuanController extends Controller
{

    public function index(Request $request){
        $start = $request->input('start')." 00:00:00";
        $end = $request->input('end')." 23:59:59";
        $groupBy = $request->input('type');
        $pageSize = $request->input('pageSize', 15);
        $where = [
            ['cb.created_at','>=',$start],
            ['cb.created_at','<=',$end] 
        ];
        if($request->has('department_id')){
            $department_id = $request->input('department_id');
            $where[] = ['cu.department_id','=',$department_id];
        }

        if($request->has('group_id')){
            $group_id = $request->input('group_id');
            $where[] = ['cu.group_id','=',$group_id];
        }

        $result = DB::table('customer_basic as cb')->select(
                DB::raw('count(cb.id) as cus_count'),
                DB::raw('count(cba.id) as c_cus_count'),
                DB::raw('count(cbas.id) as b_cus_count'),
                DB::raw('count(distinct ob.cus_id) as obcus_count'),
                DB::raw('count(ob.id) as ob_count'),
                DB::raw('count(cus.id) as track_count')
            )->addSelect('cu.department_name','cu.group_name','cu.user_name','cb.created_at','cu.department_id','cu.group_id','cu.user_id')
            ->join('customer_user as cu','cu.cus_id','=','cb.id')
            ->leftJoin('order_basic as ob','ob.cus_id','=','cb.id')
            ->join('customer_basic as cba',function($join){
                $join->on('cb.id','=','cba.id')->where('cba.type','=','C');
            },null,null,'left')
            ->join('customer_basic as cbas',function($join){
                $join->on('cbas.id','=','cb.id')->where('cbas.type','=','B');
            },null,null,'left')
            ->join('customer_user as cus',function($join){
                $join->on('cus.id','=','cu.id')->whereNotNull('cus.last_track');
            },null,null,'left')
            ->where('cu.type',0)
            ->where($where)->whereNull('cb.deleted_at')->whereNull('cu.deleted_at')
            ->groupBy('cu.'.$groupBy)
            ->paginate($pageSize);
        
        $items = $result->getCollection();
        $key = $groupBy;
        if (!$items->isEmpty()) {
            $keyValue = $items->pluck($key);
        } else {
            $keyValue = [-1];
        }
        
        $this->setTrans($key, $keyValue, $start, $end, $items);
        
            
        return [
            'items'=> $items,
            'total'=> $result->total()
        ];
    }
    
    /**
     * 
     */
    public function setTrans($groupBy, $values, $start, $end, $items)
    {   
        //转进来的
        $userInSubQuery= DB::connection('mysql_read')->table('customer_user as a')->join('customer_user as b','a.cus_id','=','b.cus_id')
        ->whereIn('b.type',[1,2])
        ->whereIN('b.'.$groupBy, $values)
        ->where([
            ['b.created_at','>=',$start],
            ['b.created_at','<=',$end],
            ['a.'.$groupBy,'!=','b.'.$groupBy]
        ])->select(DB::raw("count(b.id) as in_count"),"b.{$groupBy} as map_key")->groupby('b.'.$groupBy);
        $inResult = $userInSubQuery->get();
        if (!$inResult->isEmpty()) {
            $inMap = $inResult->mapWithKeys(function($item){
                return [$item->map_key => $item->in_count];
            });
        } else {
            $inMap = collect([1]);
        }
        $items->each(function($itm) use($inMap, $groupBy){
            $itm->trans_in =  $inMap->has($itm->{$groupBy}) ? $inMap->get($itm->{$groupBy}) : 0;
        });
        
        //转出去的
        $userOutSubQuery= DB::connection('mysql_read')->table('customer_user as a')->join('customer_user as b', 'a.cus_id','=','b.cus_id')
        ->whereIn('b.type',[1,2])
        ->whereIn('a.'.$groupBy, $values)
        ->where([
            ['a.deleted_at','>=',$start],
            ['a.deleted_at','<=',$end],
            ['a.'.$groupBy,'!=','b.'.$groupBy]
        ])
        ->select(DB::raw("count(a.id) as in_count"),"a.{$groupBy} as map_key")->groupby('a.'.$groupBy);
        $outResult = $userOutSubQuery->get();
        if (!$outResult->isEmpty()) {
            $outMap = $outResult->mapWithKeys(function($item){
                return [$item->map_key => $item->in_count];
            });
        } else {
            $outMap= collect([1]);
        }
        $items->each(function($itm) use($outMap, $groupBy){
            $itm->trans_out =  $outMap->has($itm->{$groupBy}) ? $outMap->get($itm->{$groupBy}) : 0;
        });
        
        
    }

    public function index2(Request $request)
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
        
        
        $result = DB::table('customer_basic as cus_a')//connection('mysql_read')->
        ->select(
            DB::raw('count(cus_a.id) as cus_count'), //录入客户
            DB::raw('count(c_cus.id) as c_cus_count'),//一般客户数量
            DB::raw('count(b_cus.id) as b_cus_count'), //意向客户数量
            DB::raw('count(user_track.id) as track_count')//跟踪数 ---//obcus_count 成交客户数    ob_count 成交单数
           // DB::raw('count(user_in.id) as user_in_count'),
            //DB::raw('count(user_out.id) as user_out_count')
            )
        ->addSelect(DB::raw('count(ob.id) as ob_count, count(distinct ob.cus_id) as obcus_count'))
        ->addSelect('owner.department_name','owner.group_name','owner.user_name','cus_a.created_at')
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
        ->paginate($request->input('pageSize', 20));
        // ->offset($offset)
        // ->limit($pageSize)
        // ->get();
        

        
        
        return [
            'items'=> $result->items(),
            'total'=> $result->total()
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
