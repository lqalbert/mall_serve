<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\JdOrderGoods;

class JdOrderGoodsController extends Controller
{
    public function index(Request $request)
    {
        $order_sn = $request->input('order_sn');
        $re = JdOrderGoods::where('order_sn', $order_sn)->with('originGoods')->get();
        
        return [
            'items'=>$re,
            'total'=>$re->count()
        ];
    }
}
