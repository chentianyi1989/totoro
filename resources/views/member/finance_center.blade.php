@extends('member.layouts.main')
@section('content')
<div class="userbasic_head">
    <a href="{{ route('member.finance_center') }}" class="active">会员存款</a>
    <a href="{{ route('member.member_drawing') }}" >会员提款</a>
    <a href="{{ route('member.indoor_transfer') }}">户内转账</a>
    {{--<a href="{{ route('member.finance_center') }}">自助入账</a>--}}
</div>
<div class="userbasic_body">
    <div class="bank_tips">温馨提示: 如当前支付方式未能支付成功，请您尝试其他支付方式进行支付！</div>
    <div class="account_form">
        <form action="{{ route('member.recharge_type') }}" method="get">
            <input type="hidden" id="type" name="type">
            <div class="line">
                <div class="tit">
                    存款方式
                </div>
                <div class="ways">
                    <div class="account_index">
                        <span class="ways_box card_pay" data-type="4">
                            <img src="{{ asset('/web/images/account-icon6.png') }}" class="icon">网银支付
                            <em class="check"></em>
                        </span>
                        <span class="ways_box card_pay" data-type="5">
                            <img src="{{ asset('/web/images/account-icon7.png') }}" class="icon">扫码支付
                            <em class="check"></em>
                        </span>
                        <span class="ways_box card_pay" data-type="3">
                            <img src="{{ asset('/web/images/account-icon2.png') }}" class="icon">银行卡转账
                            <em class="check"></em>
                        </span>
                        @if($_system_config->wechat_on_line == 0)
                            <span class="ways_box wechar_pay" data-type="1">
                                <img src="{{ asset('/web/images/account-icon5.png') }}" class="icon">微支付
                                <em class="check"></em>
                            </span>
                        @endif
                        @if($_system_config->alipay_on_line == 0)
                            <span class="ways_box wechar_pay" data-type="2">
                                <img src="{{ asset('/web/images/account-icon3.png') }}" class="icon">支付宝扫码
                                <em class="check"></em>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            {{--<div class="pay_toggle_tips">--}}
                {{--<div class="line alipay_line">--}}
                    {{--<div class="tit">支付宝认证姓名</div>--}}
                    {{--<input type="text" class="inp">--}}
                    {{--（您的支付宝姓名长度多余四位只填前四位即可）--}}
                {{--</div>--}}
                {{--<div class="line">--}}
                    {{--<div class="tit">存款金额</div>--}}
                    {{--<input type="text" class="inp">--}}
                    {{--元--}}
                {{--</div>--}}
            {{--</div>--}}
            <div class="line">
                <div class="tit"></div>
                <button type="button" class="ajax-submit-without-confirm-btn account_save">提交</button>
            </div>
        </form>
    </div>
</div>
@endsection
@section('after.js')
    <script>
        $(function(){
            $('.user_con').on('click','.ways .show_bank',function(){
                $('.choosebank').show();
            })
            $('.user_con').on('click','.account_index .show_bank',function(){
                $('.choosebank').show();
                $('.green_pass').hide();
            })
            $('.user_con').on('click','.account_index .ways_box',function(){
                $('.account_index .ways_box').removeClass('active');
                $(this).addClass('active');
                $('#type').val($(this).attr('data-type'))
            })
            $('.user_con').on('click','.account_index .green_way',function(){
                $('.choosebank').show();
                $('.green_pass').show();
                $('.account_form .green_tips').show();

            })
            $('.user_con').on('click','.account_index .wechar_pay',function(){
                $('.choosebank').hide();
                $('.green_pass').hide();

            })
        })
    </script>
    @endsection
