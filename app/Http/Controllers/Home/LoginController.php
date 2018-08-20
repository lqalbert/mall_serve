<?php

namespace App\Http\Controllers\Home;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use App\Models\CustomerBasic;
use App\Models\CustomerContact;

class LoginController extends CommonController
{
    //
    /*------------登录页面-------------*/
    public function index(Request $request){
        return view('home/login/index',['bar'=>static::$bar,'username'=>Cookie::get('username'),'password'=>Cookie::get('password'),'check'=>Cookie::get('check'),'checks'=>Cookie::get('checks')]);
    }
    /*------------注册-------------*/
    public function register(){
        return view('home/login/register',['bar'=>static::$bar]);
    }
    //问卷用户信息收集页面
    public function questionnaire (){
    return view('home/questionnaire/register',['bar'=>static::$bar]);
}
    //问卷用户信息保存
    public function registerAction(Request $request){
        $data = [];
        $data['name'] = $request->input('name');
        $data['age'] = $request->input('age');
        $data['type'] = 'C';
        $re = CustomerBasic::create($data);
        $data1['phone'] = $request->input('phone');
        $data1['weixin_nickname'] = $request->input('phone');
        $data1['weixin'] = $request->input('phone');
        $data1['cus_id'] = $re->id;
        $res = CustomerContact::create($data1);
        if ($res){
            return $this->success([],'ok',1);
        }

    }
    /*------------登录动作-------------*/
    public function loginIn(Request $request){
        if($request->isMethod('post')){
            $arr=$request->all();
            $num=new User();
            $nums=$num->login($arr);
            return $nums;
        }
    }
    /*------------登出-------------*/
    public function loginOut(){
        session(['isLogin'=>URL('login/index')]);
        session(['login'=>'']);
        session(['username','']);
        session(['head_img','']);
        session(['user_id','']);
        return redirect('login/index');
    }
}
