<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Goods;
use App\models\Category;

class SaleController extends CommonController
{
    //
    public  function index(){
        static::$bar['bar4']='sta';
        static::$bar['line4']='line';
        //hot_goods 应做成查询作用域
        $allgoods = Goods::active()->where('hot_goods',1)->get(['id','cover_url','goods_name','goods_price','new_goods','hot_goods']);
        return view('home/sale/index',['bar'=>static::$bar, 'allGoods'=>$allgoods]);
    }
    public  function stars(Request $request){
        $type=['wakeup'=>'','youth'=>''];
        $label = $request->input('label','焕肤紧致系列');
        if ($label == '焕肤紧致系列') {
            $type['wakeup'] = 'active';
            $yt = 'wakeup';
        } else {
            $type['youth'] = 'active';
            $yt = 'youth';
        }
//         $type[$request->input('type','wakeup')]='active';
//         $yt=$request->input('type','wakeup');
        
        
        static::$bar['bar6']='sta';
        static::$bar['line6']='line';
        
        $cate = $this->getCateByLabel($label);
        
        $allgoods = Goods::active()->whereHas('midCate',function($query) use($cate){
            $query->where('cate_id', $cate->id);
        })->get(['id','cover_url','goods_name','goods_price','new_goods','hot_goods']);
        
        
        
        return view('home/sale/stars',['bar'=>static::$bar,'type'=>$type,'yt'=>$yt, 'allGoods'=>$allgoods]);
    }
    
    private function getCateByLabel($label)
    {
        return Category::where('label', $label)->firstOrFail();
    }
}
