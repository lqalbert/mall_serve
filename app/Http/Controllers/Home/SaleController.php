<?php

namespace App\Http\Controllers\home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SaleController extends CommonController
{
    //
    public  function index(){
        static::$bar['bar4']='sta';
        static::$bar['line4']='line';
        return view('home/sale/index',['bar'=>static::$bar]);
    }
    public  function stars(Request$request){
        $type=['wakeup'=>'','youth'=>''];
        $type[$request->input('type','wakeup')]='active';
        $yt=$request->input('type','wakeup');
        static::$bar['bar6']='sta';
        static::$bar['line6']='line';
        return view('home/sale/stars',['bar'=>static::$bar,'type'=>$type,'yt'=>$yt]);
    }
}
