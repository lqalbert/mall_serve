<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class QuestionController extends CommonController
{
    //
    public function index(Request $request){
        if ($request->has('exchange')) {
            $current="exaq";
        } else {
            $current="";
        }
        return view('home/question/index',['bar'=>static::$bar, 'current'=>$current]);
    }
}
