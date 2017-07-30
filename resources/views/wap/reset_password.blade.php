@extends('wap.layouts.main')
@section('after.css')
    <link type="text/css" rel="stylesheet" href="{{ asset('/wap/css/font-awesome.min.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('/wap/css/mmenu.all.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('/wap/css/ssc.css') }}"/>
    <link type="text/css" rel="stylesheet" href="{{ asset('/wap/css/member.css') }}">
@endsection
@section('before.js')
    <script type="text/javascript" src="{{ asset('/wap/js/mmenu.all.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/wap/js/member.js') }}"></script>
@endsection
@section('content')

    <div class="container-fluid gm_main">
        <div class="head">
            <a class="f_l" href="#u_nav"><img src="{{ asset('/wap/images/user_menu.png') }}" alt=""></a>
            <span>修改密码</span>
            <a class="f_r" href="#type"><img src="{{ asset('/wap/images/user_game.png') }}" alt=""></a>
        </div>
        @include('wap.layouts.aside')
        <div id="type" style="display: none">
            <ul class="g_type">
                <li>
                    @include('wap.layouts.aside_game_list')
                </li>
            </ul>
        </div>

        <div class="userInfo setCard">
            <form action="{{ route('wap.reset_login_password') }}" method="post" name="form1">
                <dl class="set_card">
                    <dt>修改登录密码</dt>
                    <dd>
                        <div class="pull-left">
                            原登录密码
                        </div>
                        <input class="pull-left" type="password" placeholder="" name="old_password" id="oldpass">
                    </dd>
                    <dd>
                        <div class="pull-left">
                            新登录密码
                        </div>
                        <input class="pull-left" type="password" placeholder="" name="password" id="newpass">
                    </dd>
                    <dd>
                        <div class="pull-left">
                            确认新密码
                        </div>
                        <input class="pull-left" type="password" placeholder="" name="password_confirmation" id="newpass2">
                    </dd>
                    <dd>
                        <input type="button" value="确认修改" class="submit_btn ajax-submit-btn">
                    </dd>
                </dl>
            </form>
            <form action="{{ route('wap.reset_qk_password') }}" method="post" name="form1" >
                <dl class="set_card">
                    <dt>修改提款密码</dt>
                    <dd>
                        <div class="pull-left">
                            原提款密码
                        </div>
                        <input class="pull-left" type="password" placeholder="" name="old_password" id="oldmoneypass">
                    </dd>
                    <dd>
                        <div class="pull-left">
                            新提款密码
                        </div>
                        <input class="pull-left" type="password" placeholder="" name="password" id="newmoneypass">
                    </dd>
                    <dd>
                        <div class="pull-left">
                            确认新密码
                        </div>
                        <input class="pull-left" type="password" placeholder="" name="password_confirmation" id="newmoneypass2">
                    </dd>
                    <dd>
                        <input type="button" value="确认修改" class="submit_btn ajax-submit-btn">
                    </dd>
                </dl>
            </form>
        </div>
        <div class="wrap">
            <div class="info">
                <p><strong>忘记密码？</strong></p>
                <p>如果您忘记了密码，请与客服联系。</p>
                <p>为了保证会员的资金安全，请您谅解要扫描身份证件验证您的身份。</p>
                <p>也请您放心，您的资料绝对保密，感谢您对皇冠娱乐城的支持！</p>
            </div>
        </div>
    </div>
@endsection