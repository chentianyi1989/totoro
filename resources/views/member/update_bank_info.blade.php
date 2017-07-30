@extends('member.layouts.main')
@section('content')
    <div class="userbasic_head">
        <a href="{{ route('member.userCenter') }}">基本信息</a>
        <a href="{{ route('member.bank_load') }}" class="active">银行资料</a>
        <a href="{{ route('member.account_load') }}">账户设置</a>
    </div>
    <div class="userbasic_body ">
        <div class="line_form complaint_form ">
            <form action="{{ route('member.post_update_bank_info') }}" method="post">
                <div class="line">
                    <span class="tit">收款银行</span>
                    <select class="select" name="bank_name">
                        <option value="">--请选择--</option>
                        @foreach(\App\Models\Base::$BANK_TYPE as $v)
                            <option value="{{ $v }}" @if($_member->bank_name == $v) selected @endif>{{ $v }}</option>
                        @endforeach
                    </select>
                    <span class="tips"><span class="themeCr">*</span></span>
                </div>
                <div class="line">
                    <span class="tit">开户地址</span>
                    <input class="inp" placeholder="" name="bank_address" value="{{ $_member->bank_address }}">
                    <span class="tips"><span class="themeCr">*</span></span>
                </div>
                <div class="line">
                    <span class="tit">开户行网点</span>
                    <input type="text" class="inp" name="bank_branch_name" value="{{ $_member->bank_branch_name }}">
                    <span class="tips"><span class="themeCr">*</span></span>
                </div>
                <div class="line">
                    <span class="tit">开户姓名</span>
                    <input type="text" class="inp" name="bank_username" value="{{ $_member->bank_username }}">
                    <span class="tips"><span class="themeCr">*</span></span>
                </div>
                <div class="line">
                    <span class="tit">银行账号</span>
                    <input type="text" class="inp" name="bank_card" value="{{ $_member->bank_card }}">
                    <span class="tips"><span class="themeCr">*</span></span>
                </div>
                {{--<div class="line">--}}
                    {{--<span class="tit">确认账号</span>--}}
                    {{--<input type="text" class="inp">--}}
                    {{--<span class="tips"><span class="themeCr">*</span>必须与上面的卡号一致</span>--}}
                {{--</div>--}}
                {{--<div class="line">--}}
                    {{--<span class="tit">输入手机号码</span>--}}
                    {{--<input type="text" class="inp" placeholder="手机号码">--}}
                    {{--<span class="tips"><span class="themeCr">*</span>输入您的手机号码</span>--}}
                {{--</div>--}}
                {{--<div class="line line_ercode">--}}
                    {{--<span class="tit">输入验证码</span>--}}
                    {{--<input type="text" class="inp" placeholder="验证码">--}}
                    {{--<span class="tips"><span class="themeCr">*</span>必填</span>--}}
                {{--</div>--}}
                <div class="line">
                    <span class="tit"></span>
                    <button type="button" class="ajax-submit-without-confirm-btn account_save">确定</button> <a href="{{ route('member.bank_load') }}" class="account_save">返回</a>
                </div>
            </form>
        </div>
    </div>
@endsection