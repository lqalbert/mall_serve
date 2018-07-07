<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class SaleQuanController extends Controller
{
    public function index(Request $request)
    {
        $start = '2018-01-01 00:00:00';
        $end = '2018-02-02 23:59:59';
        DB::select('select sum(a.id) as cus_count from customer_basic as a where  created_at >= :start and ', ['start' => $start, 'end'=>$end]);
        
        //录入数, 成交客户数
        DB::table('customer_basic as cus_a')
        ->select(DB::raw('count(cus_a.id) as cus_count'))
        ->addSelect(DB::raw('count(ob.id) as ob_count, count(distinc ob.cus_id) as obcus_count'))
        ->join('customer_user as owner','cus_a.id','=','owner.cus_id')
        ->leftJoin('order_basic as ob','cus_a.id','=','ob.cus_id')
        ->whereNull('cus_a.deleted_at')
        ->whereNull('owner.deleted_at')
        ->where([
            ['created_at','>=',$start],
            ['created_at','<=',$end]   
        ])
        ->groupBy('status')
        ->get();
    }
}
