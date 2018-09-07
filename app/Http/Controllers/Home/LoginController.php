<?php

namespace App\Http\Controllers\Home;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use App\Models\CustomerBasic;
use App\Models\CustomerContact;
use App\Models\CustomerUser;
use App\Models\AccountSettings;

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
    public function questionnaire ($id){
    return view('home/questionnaire/register',['bar'=>static::$bar,'id'=>$id]);
}
    //问卷用户信息保存
    public function registerAction(Request $request){
//        var_dump($request->all());die;

        $has = CustomerContact::where('phone',$request->input('phone'))->first();
        $request->session()->put(['user_login_phone'=>$request->input('phone')]);
        if($has){
            return $this->success([],'该用户信息已保存',1);
        }else{
            DB::beginTransaction();
            try{
                $account = AccountSettings::where('status',1)->orderBy('created_at','desc')->first();
                $now_number = $account->now_number + 1;
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
                $data2['cus_id'] = $re->id;
                $data2['user_id'] = $account->user_id;
                $data2['user_name'] = $account->user_name;
                $data2['department_id'] = $account->department_id;
                $data2['department_name'] = $account->department_name;
                $data2['group_id'] = $account->group_id;
                $data2['group_name'] = $account->group_name;
                $res2 = CustomerUser::create($data2);
                if ($re && $res && $res2){
                    AccountSettings::where('id',$account->id)->update(['now_number'=>$now_number]);
                    DB::commit();
                    return $this->success([],'保存成功',1);
                }
            }catch (\Exception $e){
                DB::rollback();//事务回滚
                return $this->error([],'保存失败',0);
            }
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
