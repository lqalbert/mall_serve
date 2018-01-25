<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\URL;

class ProductController extends CommonController
{
    //
    public function index(){
        static::$bar['bar2']='sta';
        static::$bar['line2']='line';
        return view('home/product/index',['bar'=>static::$bar]);
    }
    public function product(){
        static::$bar['bar2']='sta';
        static::$bar['line2']='line';
        return view('home/product/product',['bar'=>static::$bar]);
    }
}
