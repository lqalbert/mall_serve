<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class IndexController extends CommonController
{
    //
    public function index(){
        static::$bar['bar1']='sta';
        static::$bar['line1']='line';
        return view('index',['bar'=>static::$bar]);
    }
}
