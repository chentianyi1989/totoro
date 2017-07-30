@extends('web.layouts.main')
@section('content')
    <div class="body" style="background: url(https://static.tb6678.com/tb2d1/image/pic/bg/live/online_live_bg.jpg) no-repeat;">
        <div class="container tbbg-margin">
            <div class="notice clear">
                <div class="notice-bg"></div>
                <div class="notice-title pullLeft">
                    <div class="notice-title_bg"></div>
                    <span class="bg-icon pullLeft"></span>
                    系统公告
                </div>
                <marquee id="mar0" scrollAmount="4" direction="left" onmouseout="this.start()" onmouseover="this.stop()">
                    @foreach($system_notices as $v)
                        <span>~{{ $v->title }}~</span>
                        <span>{{ $v->content }}</span>
                    @endforeach
                </marquee>
            </div>
            <ul class="live-ul clear">
                <li class="pullLeft live-li-margin on">
                    <div class="live-mnv mnv-3">
                        <h2 class="pullRight">
                            AG国际厅<br><em>asia gaming</em>
                        </h2>
                    </div>
                    <div class="live-mshu">
                        <h2 class="liveCasino_title">AG国际厅</h2>
                        <p>体验投注激情，让您乐在其中!</p>
                        <div class="live-link">
                            <a href="javascript:;" class="pullRight live-link-1 pointer" @if($_member) onclick="javascript:window.open('{{ route('ag.playGame') }}?id=12','','width=1024,height=768')" @else onclick="return alert('请先登录！')"  @endif></a>
                        </div>
                    </div>
                </li>
                <li class="pullLeft live-li-margin">
                    {{--<img class="isComing" src="{{ asset('/web/images/isComing.png') }}" alt="">--}}
                    <div class="live-mnv mnv-1">
                        <h2 class="pullRight">
                            AG旗舰厅
                            <br>
                            <em>asia gaming</em>
                        </h2>
                    </div>
                    <div class="live-mshu">
                        <h2 class="liveCasino_title">AG旗舰厅</h2>
                        <p>现场360度视角，实时显示输赢排行榜，推荐最好牌路，多款游戏同台下注，百家乐，龙虎，骰宝等</p>

                        <div class="live-link">
                            <a href="javascript:;" class="pullRight live-link-1 pointer" @if($_member) onclick="javascript:window.open('{{ route('ag.playGame') }}?id=13','','width=1024,height=768')" @else onclick="return alert('请先登录！')"  @endif></a>
                        </div>
                    </div>
                </li>
                <li class="pullLeft live-li-margin">
                    <img class="isComing" src="{{ asset('/web/images/isComing.png') }}" alt="">
                    <div class="live-mnv mnv-2">
                        <h2 class="pullRight">
                            波音厅
                            <br>
                            <em>asia gaming</em>
                        </h2>
                    </div>
                    <div class="live-mshu">
                        <h2 class="liveCasino_title">波音厅</h2>
                        <p>现场360度视角，实时显示输赢排行榜，推荐最好牌路，多款游戏同台下注，百家乐，龙虎，骰宝等</p>

                        <div class="live-link">
                            <a href="javascript:;" class="pullRight live-link-1 pointer isComingSoon"></a>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <div class="notice_layer">
        <h3>公告详情 <span class="close"></span></h3>
        <div class="notice_con">
            @foreach($system_notices as $v)
                <div class="module">
                    <h4>{{ $v->title }}</h4>
                    <p>✿{{ $v->content }}</p>
                </div>
            @endforeach
            {{--<div class="module">--}}
            {{--<h4>波音游戏</h4>--}}
            {{--<p>✿尊敬的{{ $_system_config->site_name }}会员， 由于波音平台电子游戏本身不具备记忆功能，如果您在游戏中由于网络连接服务器不稳定导致意外断线，重新登陆将无法继续完成上一局断开的游戏进程；很抱歉的告知您此类情况BBIN平台一律不予赔付，恕与本网站无关！ 建议您可以尝试PT、TTG、BSG或者MG平台游戏，种类更多，更有高达1.7%的洗码优惠！！！</p>--}}
            {{--</div>--}}
            {{--<div class="module">--}}
            {{--<h4>郑重声明</h4>--}}
            {{--<p>✿尊敬的会员，近期有很多私人QQ账号、QQ群和微信公众号冒充{{ $_system_config->site_name }}/{{ $_system_config->site_name }}代理的名义，四处招摇撞骗。在此{{ $_system_config->site_name }}提醒各位会员，请妥善保管好私人信息。网站所有优惠，充值方式，都以官网为准，请不要相信其他任何信息，以免造成不必要的损失！</p>--}}
            {{--</div>--}}
            {{--<div class="module">--}}
            {{--<h4>通知</h4>--}}
            {{--<p>✿ 最近波音平台检测到个别玩家有异常下注行为，影响到游戏的公平公正。根据波音平台处理意见，一旦波音平台查实，公司有权在毫无警告或通知下取消此会员所有的注单并冻结帐户，不予提款处理！对于不听劝告的玩家，后果自负！</p>--}}
            {{--</div>--}}
        </div>
    </div>
    <script>


        (function ($) {
            $(function () {
                $('.live-ul li').on('mouseenter',function(){
                    console.log($(this));
                    $(this).addClass('on').siblings('li').removeClass('on');
                });

                $('.menuBox').on('click', 'li', function () {
                    var index = $(this).index();
                    var $contentBox_item=$(this).closest('.menuBox').next('.contentBox').find('.contentBox_item');
                    $(this).addClass('active').siblings('li').removeClass('active');
                    $contentBox_item.removeClass('active').eq(index).addClass('active');
                });

                //公告
                $('#mar0').on('click',function(){
                    var notice_index=layer.open({
                        type: 1,
                        title: false,
                        closeBtn: 0,
                        area: ['680px'],
                        skin: 'layui-layer-nobg', //没有背景色
                        shadeClose: true,
                        content: $('.notice_layer')
                    });

                    $('.notice_layer').on('click','.close',function(){
                        layer.close(notice_index)
                    })
                });

                $('.isComingSoon').on('click',function(){
                    layer.msg('暂未开放，敬请期待',{icon:6});
                });


                //superslide
                jQuery(".txtScroll-top").slide({mainCell:".bd ul",autoPage:true,effect:"top",autoPlay:true,vis:9,pnLoop:true});
            })
        })(jQuery)
    </script>
@endsection