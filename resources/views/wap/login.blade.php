@extends('wap.layouts.main')
@section('content')
    <div class="container-fluid login">
        <div class="head">
            <a class="f_l" href="javascript:history.back();" style="width: 30px;font-size: 30px"><i class="icon-angle-left"></i></a>
            <a>用户登录</a>
            <a class="f_r" href="/" style="width: 40px;font-size: 25px"><i class="icon-home"></i></a>
        </div>
        <div class="con">
            <form id="loginForm"  action="{{ route('wap.login.post') }}" method="post">
                <ul>
                    <li>
                        <input id="username" name="name" type="text" placeholder="账号" class="form-control input-lg inp">
                        <i class="icon-user icon-large form-control-feedback ico"></i>
                    </li>
                    <li>
                        <input id="passwd" name="password" type="password" placeholder="密码" class="form-control input-lg inp">
                        <i class="icon-lock icon-large form-control-feedback ico"></i>
                    </li>
                    <li>
                        <input type="hidden" name="act" value="login">
                        <input id="loginBtn" type="button" class="btn btn-danger btn-lg ajax-submit-btn" value="立即登录">
                    </li>
                    <li>
                        <a class="f_l ft_18" href="{{ route('wap.register') }}">快速注册</a>
                        <a class="f_r ft_18 f_pwd" href="javascript:alert('遗忘密码，请联系客服人员！');">忘记密码？</a>
                    </li>
                </ul>
            </form>
        </div>
    </div>
@endsection