<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //
    
    public function login(Request $request) 
    {
        
        if (Auth::attempt(['account'=>$request->input('account'), 'password'=>$request->input('password')])) {
            $user = Auth::user();
//             $user->roles()->withoutGlobalScope('hide');
            $user->roles;
            return $this->success($user, '登录成功');
        } else {
            return $this->error(null, '账号或密码错误');
        }
    }
    
    public function out(Request $request) 
    {
        Auth::logout();
        return $this->success(null, '退出成功');
    }
}
