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
            <span>在线充值</span>
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
        <img src="{{ asset('/wap/images/pay_online_bg.jpg') }}" alt="" style="max-width: 100%;margin-top: 8px;">
        <div class="wrap">
            <div align="center" class="pay-style">
                <!-- 网银支付-->
                <a href="{{ route('wap.third_bank_pay') }}">
                    <img src="{{ asset('/wap/images/m_unipay.png') }}" class="pic"/>
                    <div class="text">网银支付</div>
                </a>
            </div>
            <div align="center" class="pay-style">
                <!-- 扫码支付-->
                <a href="{{ route('wap.third_pay_scan') }}">
                    <img src="{{ asset('/wap/images/m_scan.png') }}" class="pic"/>
                    <div class="text">扫码支付</div>
                </a>
            </div>
            <div align="center" class="pay-style">
                <!-- 银行卡转账-->
                <a href="{{ route('wap.bank_pay') }}">
                    <img src="{{ asset('/wap/images/m_card.png') }}" class="pic"/>
                    <div class="text">银行卡转账</div>
                </a>
            </div>
            @if($_system_config->wechat_on_line == 0)
                <div align="center" class="pay-style">
                    <!-- 微信转账-->
                    <a href="{{ route('wap.weixin_pay') }}">
                        <img src="{{ asset('/wap/images/m_weixinpay.png') }}" class="pic"/>
                        <div class="text">微信转账</div>
                    </a>
                </div>
            @endif
            @if($_system_config->alipay_on_line == 0)
                <div align="center" class="pay-style">
                    <!-- 支付宝转账-->
                    <a href="{{ route('wap.ali_pay') }}">
                        <img src="{{ asset('/wap/images/m_alipay.png') }}" class="pic"/>
                        <div class="text">支付宝转账</div>
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection