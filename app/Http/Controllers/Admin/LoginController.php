<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;

use App\Http\Middleware\Admin\AdminAuth;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Validator;


class LoginController extends Controller
{
    /**
     * AdminLogin 后台登录模块
     * @author kuoteo <894569910@qq.com>
     * @param  Request $request [description]
     * @return [type]           [description]
     */

    public function index(Request $request)
    {
        //判断请求方式
        if($request->isMethod('get')) {
            return view('admin.login');
        }elseif ($request->isMethod('post')){
            //数据验证
            $validator= Validator::make($request->all(),[
                'username'=>'required|min:2|max:16',
                'password'=>'required'
            ]);
            if($validator->fails()){
                return redirect(route('admin.login'))
                    ->withErrors($validator)
                    ->withInput();
            }

            //用户认证
            if(Auth::attempt([
                'username'=>$request->username,
                'password'=>$request->password,
            ])){
                flash("欢迎回来,{$request->username}");
                return redirect(route('admin.product'));
            }
            else{
                flash('用户名或密码错误')->error();
                return back();
            }

        }
    }

    /**
     * logout 登出
     * @author kuoteo<894569910@qq.com>
     * @return [type] [description]
     */
    public function logout()
    {
        Auth::logout();
        return redirect(route('admin.login'));
    }

}
