@extends('wap.layouts.main')
@section('content')
    <div class="container-fluid reg">
        <div class="head">
            <a class="f_l" href="javascript:history.back();" style="width: 30px;font-size: 30px"><i class="icon-angle-left"></i></a>
            <a>账号注册</a>
            <a class="f_r" href="/" style="width: 40px;font-size: 25px"><i class="icon-home"></i></a>
        </div>
        <div class="con">
            <form id="form1"  action="{{ route('wap.register.post') }}" method="post" name="form1">
                <input type="hidden" name="i_code" value="{{ $i_code }}">
                <ul>
                    <li><input id="zcname" name="name" type="text" placeholder="用户名(7-10位字符)" minlength="7" maxlength="10" class="form-control input-lg"></li>
                    <li><input id="passwd" name="password" type="password" placeholder="密码" minlength="6" maxlength="14" class="form-control input-lg"></li>
                    <li><input id="passwdse" name="password_confirmation" type="password" placeholder="再次输入密码" maxlength="20" class="form-control input-lg"></li>
                    <li><input id="realname" name="real_name" type="text" placeholder="真实姓名(与银行卡开户人相同)" maxlength="10" class="form-control input-lg"></li>
                    <li><input id="paypasswd" name="qk_pwd" type="password" placeholder="提款密码(6位纯数字)" maxlength="6" class="form-control input-lg"></li>
                    <li><input name="regBtn" type="button" class="btn btn-danger btn-lg ajax-submit-btn" value="立即注册"></li>
                    <li><a href="{{ route('wap.login') }}" class="btn btn-danger btn-lg">已有账号，登陆！</a></li>
                    <li class="f_pwd">
                        <strong>注意：</strong>
                        <p>1、提款密码必须为6位数的数字；</p>
                        <p>2、姓名必须与你用于提款的银行户口名字一致，否则无法提款。</p>
                    </li>
                </ul>
            </form>
        </div>
    </div>
@endsection