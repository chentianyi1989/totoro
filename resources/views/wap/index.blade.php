@extends('wap.layouts.main')
@section('after.css')

    <link type="text/css" rel="stylesheet" href="{{ asset('/wap/css/main.css') }}">
@endsection
@section('content')
    @include('wap.layouts.header')
    @include('wap.layouts.nav')
    <div class="news_warp">
        <span class="pull-left"><img src="{{ asset('/wap/images/on.png') }}" alt=""></span>
        <em class="pull-left">官方公告</em>
        <div class="container-fluid notice">
            <?php
                $n_str = '';
                foreach ($system_notices as $item)
                    $n_str .= $item->content.'&nbsp;&nbsp;&nbsp;';
            ?>
            <div id="news" class="move">{{ $n_str }}</div>
        </div>
    </div>
    <div class="daohang">
        <dl><a href="{{ route('wap.recharge') }}" target="_self" title="账户充值" class="dhye1 clear">
                <dt><img src="{{ asset('/wap/images/nav1.png') }}" alt=""></dt>
                <dd>账户充值</dd>
            </a>
        </dl>
        <dl><a href="{{ route('wap.transfer') }}" target="_self" title="额度转换" class="dhye3 clear">
                <dt><img src="{{ asset('/wap/images/nav2.png') }}" alt=""></dt>
                <dd>额度转换</dd>
            </a>
        </dl>
        <dl><a href="{{ route('wap.userinfo') }}" target="_self" title="会员中心" class="dhye2 clear">
                <dt><img src="{{ asset('/wap/images/nav3.png') }}" alt=""></dt>
                <dd>会员中心</dd>
            </a>
        </dl>
        <div class="clearfix"></div>
    </div>
    <div class="container-fluid games">
        <ul class="clear">
            <li>
                <a href="{{ route('ag.playGame') }}?id=0">

                    <img src="{{ asset('/wap/images/game/game_7.png') }}" alt="">
                    <p>AG电游</p>
                </a>
            </li>
            <li>
                <a href="{{ route('bbin.playGame') }}?pageSite=game">
                    <img src="{{ asset('/wap/images/game/game_2.png') }}" alt="">
                    <p>BBIN电游</p>
                </a>
            </li>
            <li>
                <a href="{{ route('ag.playGame') }}?id=12">

                    <img src="{{ asset('/wap/images/game/game_3.png') }}" alt="">
                    <p>AG旗舰</p>
                </a>
            </li>
            <li>
                <a href="{{ route('ag.playGame') }}?id=13">

                    <img src="{{ asset('/wap/images/game/game_6.png') }}" alt="">
                    <p>AG国际</p>
                </a>
            </li>
            <li>
                <a href="{{ route('bbin.playGame') }}?pageSite=live">

                    <img src="{{ asset('/wap/images/game/game_4.png') }}" alt="">
                    <p>BBIN视讯</p>
                </a>
            </li>
            <li>
                <a href="{{ route('bbin.playGame') }}?pageSite=Ltlottery">

                    <img src="{{ asset('/wap/images/game/game_11.png') }}" alt="">
                    <p>BBIN彩票</p>
                </a>
            </li>
            <li>
                <a href="{{ route('bbin.playGame') }}?pageSite=ball">
                    <img src="{{ asset('/wap/images/game/game_12.png') }}" alt="">
                    <p>BBIN体育</p>
                </a>
            </li>
            <li>
                <a href="javascript:;">
                    <img class="isComing" src="{{ asset('/wap/images/game/isComing.png') }}" alt="">
                    <img src="{{ asset('/wap/images/game/game_5.png') }}" alt="">
                    <p>MG电游</p>
                </a>
            </li>
            <li>
                <a href="javascript:;">
                    <img class="isComing" src="{{ asset('/wap/images/game/isComing.png') }}" alt="">
                    <img src="{{ asset('/wap/images/game/game_8.png') }}" alt="">
                    <p>PNG电游</p>
                </a>
            </li>
            <li>
                <a href="javascript:;">
                    <img class="isComing" src="{{ asset('/wap/images/game/isComing.png') }}" alt="">
                    <img src="{{ asset('/wap/images/game/game_1.png') }}" alt="">
                    <p>PT电游</p>
                </a>
            </li>
            <li>
                <a href="javascript:;">
                    <img class="isComing" src="{{ asset('/wap/images/game/isComing.png') }}" alt="">
                    <img src="{{ asset('/wap/images/game/game_10.png') }}" alt="">
                    <p>PT视讯</p>
                </a>
            </li>
            <li>
                <a href="javascript:;">
                    <img class="isComing" src="{{ asset('/wap/images/game/isComing.png') }}" alt="">
                    <img src="{{ asset('/wap/images/game/game_9.png') }}" alt="">
                    <p>PT捕鱼</p>
                </a>
            </li>
        </ul>
    </div>
@endsection