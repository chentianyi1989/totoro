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
            <a class="f_l" href="javascript:history.go(-1)"><img src="{{ asset('/wap/images/user_back.png') }}" alt=""></a>
            <span>微信充值</span>
            <a class="f_r" href="javascript:history.go(-1)" style="visibility: hidden"><img src="{{ asset('/wap/images/user_back.png') }}" alt=""></a>
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
            <form action="{{ route('wap.post_agent_apply') }}" method="post" name="form1">
                <dl class="set_card">
                    <dt>
                        代理申请
                    </dt>
                    <dd>
                        <div class="pull-left">
                            QQ
                        </div>
                        <input id="qq" class="pull-left" type="tel" placeholder="QQ" name="qq">
                    </dd>
                    <dd>
                        <div class="pull-left">联系电话</div>
                        <input id="phone" class="pull-left" type="tel" placeholder="联系电话" name="phone">
                    </dd>
                    <dd>
                        <div class="pull-left">填写申请</div>
                        <textarea name="about" id="about" rows="10"></textarea>
                    </dd>
                    <dd>
                        <button type="button" class="submit_btn ajax-submit-btn">确定</button>
                    </dd>
                </dl>
            </form>
        </div>
    </div>
@endsection