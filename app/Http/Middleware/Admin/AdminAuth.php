<?php

namespace App\Http\Middleware\Admin;

use Illuminate\Support\Facades\Auth;

use Closure;

class AdminAuth
{

    public function handle($request,Closure $next){
        //判断是否登录状态
        if(Auth::guest() && $request->path()!='admin/index'){
            return redirect(route('admin.login'));
        }
        if(!Auth::guest() && $request->path()=='admin/index'){
            return redirect(route('admin.product'));
    }
        return $next($request);
    }


}