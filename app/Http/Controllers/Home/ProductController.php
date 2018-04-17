<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\URL;
use App\Models\Goods;

class ProductController extends CommonController
{
    //
    public function index(Request$request){
        static::$bar['bar2']='sta';
        static::$bar['line2']='line';
        $type=array('sale'=>'','youth'=>'','all'=>'','wakeup'=>'','new'=>'');
        $type[$request->input('type','all')]='actionBar';
        $name=array('sale'=>'畅销产品','youth'=>'青春系列','all'=>'全部','wakeup'=>'焕肤紧致系列','new'=>'新品首发');
        $goods = Goods::all();

        return view('home/product/index',['bar'=>static::$bar, 'goods'=>$goods,'type'=>$type,'name'=>$name[$request->input('type','all')]]);
    }
    public function product(Request $request){
        static::$bar['bar2']='sta';
        static::$bar['line2']='line';
        
        /*if ($request->has('id')) {
        	$goods = Goods::find($request->input('id'));
        	
        	$allgoods = Goods::all(['id','goods_name','cover_url','goods_price']);
        } else {
        	abort(404);
        }*/
        /*return view('home/product/product',['bar'=>static::$bar, 'goods'=>$goods, 'allgoods' => $allgoods]);*/
        return view('home/product/product',['bar'=>static::$bar]);
    }
}
