@extends('member.layouts.main')
@section('content')
    <div class="userbasic_head">
        <a href="{{ route('member.finance_center') }}" class="active">会员存款</a>
        <a href="{{ route('member.member_drawing') }}" >会员提款</a>
        <a href="{{ route('member.indoor_transfer') }}">户内转账</a>
        {{--<a href="{{ route('member.finance_center') }}">自助入账</a>--}}
    </div>

    <!--第二个页面开始-->
    <div class="userbasic_body">
        <div class="bank_tips">温馨提示: 支付宝扫码充值范围100-2000元！ 微信扫码充值范围100-3000元！</div>
        <div class="pay_way_wrap">
            <form action="{{ route('pay_scan') }}" method="post">
                {!! csrf_field() !!}
                <div class="pay_way_line">
                    <div class="tit" style="padding-top: 36px;">二维码类型</div>
                    <div class="con">
                        <select name="typeId" required>
                            <option value="1">支付宝</option>
                            <option value="2">微信</option>
                        </select>
                    </div>
                </div>
                <div class="pay_way_line">
                    <div class="tit">转账金额</div>
                    <div class="con">
                        <p><input type="text" class="inp" name="amount" required> 元</p>
                    </div>
                </div>
                <div class="pay_way_line">
                    <div class="tit"></div>
                    <div class="con">
                        <button type="submit" class="account_save">提 交</button> <a href="{{ route('member.finance_center') }}" class="account_save">返回</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('after.js')
@endsection
