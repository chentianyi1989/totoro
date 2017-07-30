@extends('web.layouts.main')
@section('content')
    <div class="top_margin">
        <div class="container">
            <div class="register_con login_con">
                <div class="top">
                    <a href="javascript:;" class="active">登录</a>
                    {{--<a href="javascript:;"><span class="num">②</span>填写详细资料</a>--}}
                    {{--<a href="javascript:;"><span class="num">③</span>注册成功</a>--}}
                </div>
                <div class="register_left login_left">
                    <div class="bank_tips">温馨提示： 标志*为必填项目 注意：如发现客户拥有多个账户，其帐户将会被冻结并且取消所有胜出的投注，恕不另行通知。</div>
                    <div class="line_form">
                        <form method="POST" action="{{ route('member.login.post') }}">
                            <div class="line">
                                <span class="tit">登录账号</span>
                                {{--<div class="add_form">--}}
                                    {{--<span class="front">tb</span>--}}
                                    <input class="username inp" type="text" placeholder="请输入用户名" required name="name">
                                {{--</div>--}}
                                <span class="tips"><span class="themeCr">*</span>必须是7-10个字符，可使用字母、数字，首位不能为0</span>
                            </div>
                            <div class="line">
                                <span class="tit">登录密码</span>
                                <input class="psw inp" type="password" placeholder="请输入密码" required name="password">
                                <span class="tips"><span class="themeCr">*</span>6-12位数字英文或数字组合,且不包括【<span class="special">/\#%"'.?</span>】这些字符</span>
                            </div>
                            {{--<div class="line">--}}
                                {{--<span class="tit">确认密码</span>--}}
                                {{--<input type="password" class="inp" name="password_confirmation">--}}
                                {{--<span class="tips"><span class="themeCr">*</span>必须与登录密码一致</span>--}}
                            {{--</div>--}}
                            <div class="line minline">
                                <span class="tit"></span>
                                <input type="checkbox" class="checkbox" checked="checked" name="check1" value="1">
                                提呈申请的同时，本人已超过合法年龄以及本人在此网站的所有活动幷没有抵触本人所身在的国家所管辖的法律。
                            </div>
                            <div class="line minline">
                                <span class="tit"></span>
                                <input type="checkbox" class="checkbox" checked="checked" name="check2" value="2">
                                本人也接受在此项申请下有关的所有规则与条例以及隐私声明。
                            </div>
                            <div class="line">
                                <span class="tit"></span>
                                <a href="javascript:;" class="ajax-submit-without-confirm-btn account_save ajax-submit-btn">确定</a>
                                {{--<a href="javascript:void(0)" class="account_save">重新填写</a>--}}
                            </div>
                        </form>
                    </div>
                </div>
                {{--<div class="register_links">--}}
                    {{--<img src="{{ asset('/web/images/n-reg-bg3a.png') }}">--}}
                {{--</div>--}}
            </div>

            @include('web.layouts.hot_act')
        </div>
    </div>
@endsection