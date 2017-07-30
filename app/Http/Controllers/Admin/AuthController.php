<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
class AuthController extends Controller
{
   // use CurlRequest;

    /**
     * 视图：登录
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getLogin()
    {
        if (Auth::user())
            return redirect()->to(route('admin.index'));
        return view('admin.auth.login');
    }

    /**
     * 动作：执行登录
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postLogin(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], true))
        {
            return respS('登录成功',  route('admin.index'));
        }
        return respF('邮箱或密码错误');
    }

    /**
     * 动作：退出
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getLoginOut()
    {
        Auth::logout();
        return redirect()->guest('admin/login');
    }
}