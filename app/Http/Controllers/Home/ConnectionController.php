<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Connection;

class ConnectionController extends CommonController
{
    //
    public function index(){
        static::$bar['bar7']='sta';
        static::$bar['line7']='line';
        return view('home/connection/index',['bar'=>static::$bar]);
    }
    
    public function technology(){
        return view('home/connection/technology',['bar'=>static::$bar]);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $re = Connection::create($request->input());
        if($re){
            return $this->success($re);
        }else{
            return $this->error($re);
        }
    }
}
