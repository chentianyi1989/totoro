@extends('member.layouts.main')
@section('content')
<div class="userbasic_head">
    {{--<a href="{{ route('member.safe_manage') }}">安全验证</a>--}}
    <a href="{{ route('member.safe_psw') }}">取款密码</a>
    <a href="{{ route('member.login_psw') }}" class="active">登录密码</a>
</div>
<div class="userbasic_body">
    <div class="bank_tips">温馨提示：修改后请牢记您的登录密码</div>
    <div class="line_form">
        <form action="{{ route('member.update_login_password') }}" method="post">
            <div class="line">
                <span class="tit">原密码</span>
                <input type="password" class="inp" name="old_password">
                <span class="tips"><span class="themeCr">*</span></span>
            </div>
            <div class="line">
                <span class="tit">新密码</span>
                <input type="password" class="inp" name="password">
                <span class="tips"><span class="themeCr">*</span>至少6位数字字母密码</span>
            </div>
            <div class="line">
                <span class="tit">确认密码</span>
                <input type="password" class="inp" name="password_confirmation">
                <span class="tips"><span class="themeCr">*</span></span>
            </div>
            <div class="line">
                <span class="tit"></span>
                <button type="button" class="ajax-submit-btn account_save">确定</button>
            </div>
        </form>
    </div>

</div>
    @endsection
