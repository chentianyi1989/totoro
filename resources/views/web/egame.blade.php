@extends('web.layouts.main')
@section('content')

    <div class="body"
         style="background: url('{{ asset('/web/images/egame-banner.jpg') }}') no-repeat;">
        <div class="container tbbg-margin">
            <div class="notice clear" style="margin-top:-220px">
                <div class="notice-bg"></div>
                <div class="notice-title pullLeft">
                    <div class="notice-title_bg"></div>
                    <span class="bg-icon pullLeft"></span>
                    系统公告
                </div>
                <marquee id="mar0" scrollAmount="4" direction="left" onmouseout="this.start()"
                         onmouseover="this.stop()">
                    @foreach($system_notices as $v)
                        <span>~{{ $v->title }}~</span>
                        <span>{{ $v->content }}</span>
                    @endforeach
                </marquee>
            </div>
            <div class="egameslide">
                <div class="hd">
                    <ul>
                        <li class="on">
                            <p class="pic">
                                <img src="{{ asset('/web/images/app-bg-ag1.png') }}" class="default">
                                <img src="{{ asset('/web/images/app-bg-ag2.png') }}" class="activepic">
                            </p>
                            <p class="tit">AG厅</p>
                        </li>
                        <div class="last">
                            <a href="javascript:;"
                               @if($_member) onclick="javascript:window.open('{{ route('bbin.playGame') }}?pageSite=game','','width=1024,height=768')"
                               @else onclick="return layer.msg('请先登录!',{icon:6})" @endif>
                                {{--<img class="isComing" src="{{ asset('/web/images/isComing2.png') }}" alt="">--}}
                                <p class="pic">
                                    <img src="{{ asset('/web/images/app-bg-by1.png') }}" style="display: inline-block">
                                </p>
                                <p class="tit">波音厅</p>
                            </a>
                        </div>
                        {{--<li class="disabled">--}}
                            {{--<img class="isComing" src="{{ asset('/web/images/isComing2.png') }}" alt="">--}}
                            {{--<p class="pic">--}}
                                {{--<img src="{{ asset('/web/images/app-bg-mg1.png') }}" class="default">--}}
                                {{--<img src="{{ asset('/web/images/app-bg-mg2.png') }}" class="activepic">--}}
                            {{--</p>--}}
                            {{--<p class="tit">MG厅</p>--}}
                        {{--</li>--}}
                        {{--<li class="disabled">--}}
                            {{--<img class="isComing" src="{{ asset('/web/images/isComing2.png') }}" alt="">--}}
                            {{--<p class="pic">--}}
                                {{--<img src="{{ asset('/web/images/app-bg-png1.png') }}" class="default">--}}
                                {{--<img src="{{ asset('/web/images/app-bg-png2.png') }}" class="activepic">--}}
                            {{--</p>--}}
                            {{--<p class="tit">PNG厅</p>--}}
                        {{--</li>--}}
                        {{--<li class="disabled">--}}
                            {{--<img class="isComing" src="{{ asset('/web/images/isComing2.png') }}" alt="">--}}
                            {{--<p class="pic">--}}
                                {{--<img src="{{ asset('/web/images/app-bg-pt1.png') }}" class="default">--}}
                                {{--<img src="{{ asset('/web/images/app-bg-pt2.png') }}" class="activepic">--}}
                            {{--</p>--}}
                            {{--<p class="tit">PT厅</p>--}}
                        {{--</li>--}}
                        {{--<li class="disabled">--}}
                        {{--<img class="isComing" src="{{ asset('/web/images/isComing2.png') }}" alt="">--}}
                        {{--<p class="pic">--}}
                        {{--<img src="{{ asset('/web/images/app-bg-mg1.png') }}" class="default">--}}
                        {{--<img src="{{ asset('/web/images/app-bg-mg2.png') }}" class="activepic">--}}
                        {{--</p>--}}
                        {{--<p class="tit">MG国际厅</p>--}}
                        {{--</li>--}}
                        {{--<li class="disabled">--}}
                            {{--<img class="isComing" src="{{ asset('/web/images/isComing2.png') }}" alt="">--}}
                            {{--<p class="pic">--}}
                                {{--<img src="{{ asset('/web/images/app-bg-ttg1.png') }}" class="default">--}}
                                {{--<img src="{{ asset('/web/images/app-bg-ttg2.png') }}" class="activepic">--}}
                            {{--</p>--}}
                            {{--<p class="tit">TTG厅</p>--}}

                        {{--</li>--}}

                    </ul>
                </div>
                <div class="bd">
                    <div class="module" style="display: block">
                        <div class="top">
                            <div class="egameTit"></div>
                            <div class="egame_filter_top">
                                <span class="title"><img src="{{ asset('/web/images/pt-pic-bz.png') }}">AG厅</span>
                                <span class="list_wrap active"><a href="javascript:void(0)" class="list ">全部</a></span>
                                {{--<span class="list_wrap"><a href="javascript:void(0)" class="list">最新上线</a></span>--}}
                                {{--<span class="list_wrap">--}}
                                {{--<select class="list">--}}
                                {{--<option>选择游戏类型</option>--}}
                                {{--<option>选择游戏类型</option>--}}
                                {{--</select>--}}
                                {{--</span>--}}
                                {{--<span class="list_wrap">--}}
                                {{--<a href="javascript:void(0)" class="list">我的收藏 <i class="iconfont love">&#xe634;</i></a>--}}
                                {{--</span>--}}
                                {{--<div class="list_showtype">--}}
                                {{--<a href="javascript:void(0)" class="list_one"><i class="iconfont">&#xe684;</i></a>--}}
                                {{--<a href="javascript:void(0)" class="list_two"><i class="iconfont">&#xe618;</i></a>--}}
                                {{--</div>--}}
                                {{--<div class="search_inp">--}}
                                {{--<input type="text" class="inp" placeholder="请输入游戏名称">--}}
                                {{--<i class="iconfont">&#xe601;</i>--}}
                                {{--</div>--}}
                            </div>
                        </div>
                        <div class="bodylist">
                            <div class="egame_list">
                                <ul>
                                    <li class="scrollLoading" style="width: 130px;height: 168.44px">
                                        <a href="javascript:;" @if($_member) onclick="javascript:window.open('{{ route('ag.playGame') }}?id=501','','width=1024,height=768')" @else onclick="return alert('请先登录！')"  @endif>
                                            <img data-original="{{ asset('/web/images/games/ag/501.jpg')}}" class="lazy">
                                            <p class="collect">水果拉霸</p >
                                            <span class="button">开始游戏</span>
                                        </a>
                                    </li>
                                    <li class="scrollLoading" style="width: 130px;height: 168.44px">
                                        <a href="javascript:;" @if($_member) onclick="javascript:window.open('{{ route('ag.playGame') }}?id=509','','width=1024,height=768')" @else onclick="return alert('请先登录！')"  @endif>
                                            <img data-original="{{ asset('/web/images/games/ag/509.jpg')}}" class="lazy">
                                            <p class="collect">复古花园</p >
                                            <span class="button">开始游戏</span>
                                        </a>
                                    </li>
                                    <li class="scrollLoading" style="width: 130px;height: 168.44px">
                                        <a href="javascript:;" @if($_member) onclick="javascript:window.open('{{ route('ag.playGame') }}?id=508','','width=1024,height=768')" @else onclick="return alert('请先登录！')"  @endif>
                                            <img data-original="{{ asset('/web/images/games/ag/508.jpg')}}" class="lazy">
                                            <p class="collect">太空漫遊</p >
                                            <span class="button">开始游戏</span>
                                        </a>
                                    </li>
                                    <li class="scrollLoading" style="width: 130px;height: 168.44px">
                                        <a href="javascript:;" @if($_member) onclick="javascript:window.open('{{ route('ag.playGame') }}?id=537','','width=1024,height=768')" @else onclick="return alert('请先登录！')"  @endif>
                                            <img data-original="{{ asset('/web/images/games/ag/537.jpg')}}" class="lazy">
                                            <p class="collect">性感女仆</p >
                                            <span class="button">开始游戏</span>
                                        </a>
                                    </li>
                                    <li class="scrollLoading" style="width: 130px;height: 168.44px">
                                        <a href="javascript:;" @if($_member) onclick="javascript:window.open('{{ route('ag.playGame') }}?id=513','','width=1024,height=768')" @else onclick="return alert('请先登录！')"  @endif>
                                            <img data-original="{{ asset('/web/images/games/ag/513.jpg')}}" class="lazy">
                                            <p class="collect">日本武士</p >
                                            <span class="button">开始游戏</span>
                                        </a>
                                    </li>
                                    <li class="scrollLoading" style="width: 130px;height: 168.44px">
                                        <a href="javascript:;" @if($_member) onclick="javascript:window.open('{{ route('ag.playGame') }}?id=531','','width=1024,height=768')" @else onclick="return alert('请先登录！')"  @endif>
                                            <img data-original="{{ asset('/web/images/games/ag/531.jpg')}}" class="lazy">
                                            <p class="collect">侏罗纪</p >
                                            <span class="button">开始游戏</span>
                                        </a>
                                    </li>
                                    <li class="scrollLoading" style="width: 130px;height: 168.44px">
                                        <a href="javascript:;" @if($_member) onclick="javascript:window.open('{{ route('ag.playGame') }}?id=515','','width=1024,height=768')" @else onclick="return alert('请先登录！')"  @endif>
                                            <img data-original="{{ asset('/web/images/games/ag/515.jpg')}}" class="lazy">
                                            <p class="collect">麻将老虎机</p >
                                            <span class="button">开始游戏</span>
                                        </a>
                                    </li>
                                    <li class="scrollLoading" style="width: 130px;height: 168.44px">
                                        <a href="javascript:;" @if($_member) onclick="javascript:window.open('{{ route('ag.playGame') }}?id=535','','width=1024,height=768')" @else onclick="return alert('请先登录！')"  @endif>
                                            <img data-original="{{ asset('/web/images/games/ag/535.jpg')}}" class="lazy">
                                            <p class="collect">武财神</p >
                                            <span class="button">开始游戏</span>
                                        </a>
                                    </li>
                                    <li class="scrollLoading" style="width: 130px;height: 168.44px">
                                        <a href="javascript:;" @if($_member) onclick="javascript:window.open('{{ route('ag.playGame') }}?id=517','','width=1024,height=768')" @else onclick="return alert('请先登录！')"  @endif>
                                            <img data-original="{{ asset('/web/images/games/ag/517.jpg')}}" class="lazy">
                                            <p class="collect">开心农场</p >
                                            <span class="button">开始游戏</span>
                                        </a>
                                    </li>
                                    <li class="scrollLoading" style="width: 130px;height: 168.44px">
                                        <a href="javascript:;" @if($_member) onclick="javascript:window.open('{{ route('ag.playGame') }}?id=512','','width=1024,height=768')" @else onclick="return alert('请先登录！')"  @endif>
                                            <img data-original="{{ asset('/web/images/games/ag/512.jpg')}}" class="lazy">
                                            <p class="collect">甜一甜屋</p >
                                            <span class="button">开始游戏</span>
                                        </a>
                                    </li>
                                    <li class="scrollLoading" style="width: 130px;height: 168.44px">
                                        <a href="javascript:;" @if($_member) onclick="javascript:window.open('{{ route('ag.playGame') }}?id=510','','width=1024,height=768')" @else onclick="return alert('请先登录！')"  @endif>
                                            <img data-original="{{ asset('/web/images/games/ag/510.jpg')}}" class="lazy">
                                            <p class="collect">关东煮</p >
                                            <span class="button">开始游戏</span>
                                        </a>
                                    </li>
                                    <li class="scrollLoading" style="width: 130px;height: 168.44px">
                                        <a href="javascript:;" @if($_member) onclick="javascript:window.open('{{ route('ag.playGame') }}?id=519','','width=1024,height=768')" @else onclick="return alert('请先登录！')"  @endif>
                                            <img data-original="{{ asset('/web/images/games/ag/519.jpg')}}" class="lazy">
                                            <p class="collect">海底漫遊</p >
                                            <span class="button">开始游戏</span>
                                        </a>
                                    </li>
                                    <li class="scrollLoading" style="width: 130px;height: 168.44px">
                                        <a href="javascript:;" @if($_member) onclick="javascript:window.open('{{ route('ag.playGame') }}?id=516','','width=1024,height=768')" @else onclick="return alert('请先登录！')"  @endif>
                                            <img data-original="{{ asset('/web/images/games/ag/516.jpg')}}" class="lazy">
                                            <p class="collect">西洋棋老虎机</p >
                                            <span class="button">开始游戏</span>
                                        </a>
                                    </li>
                                    <li class="scrollLoading" style="width: 130px;height: 168.44px">
                                        <a href="javascript:;" @if($_member) onclick="javascript:window.open('{{ route('ag.playGame') }}?id=526','','width=1024,height=768')" @else onclick="return alert('请先登录！')"  @endif>
                                            <img data-original="{{ asset('/web/images/games/ag/526.jpg')}}" class="lazy">
                                            <p class="collect">空中战争</p >
                                            <span class="button">开始游戏</span>
                                        </a>
                                    </li>
                                    <li class="scrollLoading" style="width: 130px;height: 168.44px">
                                        <a href="javascript:;" @if($_member) onclick="javascript:window.open('{{ route('ag.playGame') }}?id=511','','width=1024,height=768')" @else onclick="return alert('请先登录！')"  @endif>
                                            <img data-original="{{ asset('/web/images/games/ag/511.jpg')}}" class="lazy">
                                            <p class="collect">牧场咖啡</p >
                                            <span class="button">开始游戏</span>
                                        </a>
                                    </li>
                                    <li class="scrollLoading" style="width: 130px;height: 168.44px">
                                        <a href="javascript:;" @if($_member) onclick="javascript:window.open('{{ route('ag.playGame') }}?id=520','','width=1024,height=768')" @else onclick="return alert('请先登录！')"  @endif>
                                            <img data-original="{{ asset('/web/images/games/ag/520.jpg')}}" class="lazy">
                                            <p class="collect">鬼马小丑</p >
                                            <span class="button">开始游戏</span>
                                        </a>
                                    </li>
                                    <li class="scrollLoading" style="width: 130px;height: 168.44px">
                                        <a href="javascript:;" @if($_member) onclick="javascript:window.open('{{ route('ag.playGame') }}?id=522','','width=1024,height=768')" @else onclick="return alert('请先登录！')"  @endif>
                                            <img data-original="{{ asset('/web/images/games/ag/522.jpg')}}" class="lazy">
                                            <p class="collect">惊吓鬼屋</p >
                                            <span class="button">开始游戏</span>
                                        </a>
                                    </li>
                                    <li class="scrollLoading" style="width: 130px;height: 168.44px">
                                        <a href="javascript:;" @if($_member) onclick="javascript:window.open('{{ route('ag.playGame') }}?id=528','','width=1024,height=768')" @else onclick="return alert('请先登录！')"  @endif>
                                            <img data-original="{{ asset('/web/images/games/ag/528.jpg')}}" class="lazy">
                                            <p class="collect">越野机车</p >
                                            <span class="button">开始游戏</span>
                                        </a>
                                    </li>
                                    <li class="scrollLoading" style="width: 130px;height: 168.44px">
                                        <a href="javascript:;" @if($_member) onclick="javascript:window.open('{{ route('ag.playGame') }}?id=532','','width=1024,height=768')" @else onclick="return alert('请先登录！')"  @endif>
                                            <img data-original="{{ asset('/web/images/games/ag/532.jpg')}}" class="lazy">
                                            <p class="collect">土地神</p >
                                            <span class="button">开始游戏</span>
                                        </a>
                                    </li>
                                    <li class="scrollLoading" style="width: 130px;height: 168.44px">
                                        <a href="javascript:;" @if($_member) onclick="javascript:window.open('{{ route('ag.playGame') }}?id=518','','width=1024,height=768')" @else onclick="return alert('请先登录！')"  @endif>
                                            <img data-original="{{ asset('/web/images/games/ag/518.jpg')}}" class="lazy">
                                            <p class="collect">夏日营地</p >
                                            <span class="button">开始游戏</span>
                                        </a>
                                    </li>
                                    <li class="scrollLoading" style="width: 130px;height: 168.44px">
                                        <a href="javascript:;" @if($_member) onclick="javascript:window.open('{{ route('ag.playGame') }}?id=523','','width=1024,height=768')" @else onclick="return alert('请先登录！')"  @endif>
                                            <img data-original="{{ asset('/web/images/games/ag/523.jpg')}}" class="lazy">
                                            <p class="collect">疯狂马戏团</p >
                                            <span class="button">开始游戏</span>
                                        </a>
                                    </li>
                                    <li class="scrollLoading" style="width: 130px;height: 168.44px">
                                        <a href="javascript:;" @if($_member) onclick="javascript:window.open('{{ route('ag.playGame') }}?id=529','','width=1024,height=768')" @else onclick="return alert('请先登录！')"  @endif>
                                            <img data-original="{{ asset('/web/images/games/ag/529.jpg')}}" class="lazy">
                                            <p class="collect">埃及奥秘</p >
                                            <span class="button">开始游戏</span>
                                        </a>
                                    </li>
                                    <li class="scrollLoading" style="width: 130px;height: 168.44px">
                                        <a href="javascript:;" @if($_member) onclick="javascript:window.open('{{ route('ag.playGame') }}?id=533','','width=1024,height=768')" @else onclick="return alert('请先登录！')"  @endif>
                                            <img data-original="{{ asset('/web/images/games/ag/533.jpg')}}" class="lazy">
                                            <p class="collect">布袋和尚</p >
                                            <span class="button">开始游戏</span>
                                        </a>
                                    </li>
                                    <li class="scrollLoading" style="width: 130px;height: 168.44px">
                                        <a href="javascript:;" @if($_member) onclick="javascript:window.open('{{ route('ag.playGame') }}?id=527','','width=1024,height=768')" @else onclick="return alert('请先登录！')"  @endif>
                                            <img data-original="{{ asset('/web/images/games/ag/527.jpg')}}" class="lazy">
                                            <p class="collect">摇滚狂迷</p >
                                            <span class="button">开始游戏</span>
                                        </a>
                                    </li>
                                    <li class="scrollLoading" style="width: 130px;height: 168.44px">
                                        <a href="javascript:;" @if($_member) onclick="javascript:window.open('{{ route('ag.playGame') }}?id=534','','width=1024,height=768')" @else onclick="return alert('请先登录！')"  @endif>
                                            <img data-original="{{ asset('/web/images/games/ag/534.jpg')}}" class="lazy">
                                            <p class="collect">正财神</p >
                                            <span class="button">开始游戏</span>
                                        </a>
                                    </li>
                                    <li class="scrollLoading" style="width: 130px;height: 168.44px">
                                        <a href="javascript:;" @if($_member) onclick="javascript:window.open('{{ route('ag.playGame') }}?id=601','','width=1024,height=768')" @else onclick="return alert('请先登录！')"  @endif>
                                            <img data-original="{{ asset('/web/images/games/ag/601.jpg')}}" class="lazy">
                                            <p class="collect">幸运8</p >
                                            <span class="button">开始游戏</span>
                                        </a>
                                    </li>
                                    <li class="scrollLoading" style="width: 130px;height: 168.44px">
                                        <a href="javascript:;" @if($_member) onclick="javascript:window.open('{{ route('ag.playGame') }}?id=602','','width=1024,height=768')" @else onclick="return alert('请先登录！')"  @endif>
                                            <img data-original="{{ asset('/web/images/games/ag/602.jpg')}}" class="lazy">
                                            <p class="collect">闪亮女郎</p >
                                            <span class="button">开始游戏</span>
                                        </a>
                                    </li>
                                    <li class="scrollLoading" style="width: 130px;height: 168.44px">
                                        <a href="javascript:;" @if($_member) onclick="javascript:window.open('{{ route('ag.playGame') }}?id=600','','width=1024,height=768')" @else onclick="return alert('请先登录！')"  @endif>
                                            <img data-original="{{ asset('/web/images/games/ag/600.jpg')}}" class="lazy">
                                            <p class="collect">龙珠</p >
                                            <span class="button">开始游戏</span>
                                        </a>
                                    </li>
                                    <li class="scrollLoading" style="width: 130px;height: 168.44px">
                                        <a href="javascript:;" @if($_member) onclick="javascript:window.open('{{ route('ag.playGame') }}?id=605','','width=1024,height=768')" @else onclick="return alert('请先登录！')"  @endif>
                                            <img data-original="{{ asset('/web/images/games/ag/605.jpg')}}" class="lazy">
                                            <p class="collect">海盗王</p >
                                            <span class="button">开始游戏</span>
                                        </a>
                                    </li>
                                    <li class="scrollLoading" style="width: 130px;height: 168.44px">
                                        <a href="javascript:;" @if($_member) onclick="javascript:window.open('{{ route('ag.playGame') }}?id=530','','width=1024,height=768')" @else onclick="return alert('请先登录！')"  @endif>
                                            <img data-original="{{ asset('/web/images/games/ag/530.jpg')}}" class="lazy">
                                            <p class="collect">欢乐时光</p >
                                            <span class="button">开始游戏</span>
                                        </a>
                                    </li>
                                    <li class="scrollLoading" style="width: 130px;height: 168.44px">
                                        <a href="javascript:;" @if($_member) onclick="javascript:window.open('{{ route('ag.playGame') }}?id=524','','width=1024,height=768')" @else onclick="return alert('请先登录！')"  @endif>
                                            <img data-original="{{ asset('/web/images/games/ag/524.jpg')}}" class="lazy">
                                            <p class="collect">海洋剧场</p >
                                            <span class="button">开始游戏</span>
                                        </a>
                                    </li>
                                    <li class="scrollLoading" style="width: 130px;height: 168.44px">
                                        <a href="javascript:;" @if($_member) onclick="javascript:window.open('{{ route('ag.playGame') }}?id=514','','width=1024,height=768')" @else onclick="return alert('请先登录！')"  @endif>
                                            <img data-original="{{ asset('/web/images/games/ag/514.jpg')}}" class="lazy">
                                            <p class="collect">象棋老虎机</p >
                                            <span class="button">开始游戏</span>
                                        </a>
                                    </li>
                                    <li class="scrollLoading" style="width: 130px;height: 168.44px">
                                        <a href="javascript:;" @if($_member) onclick="javascript:window.open('{{ route('ag.playGame') }}?id=536','','width=1024,height=768')" @else onclick="return alert('请先登录！')"  @endif>
                                            <img data-original="{{ asset('/web/images/games/ag/536.jpg')}}" class="lazy">
                                            <p class="collect">偏财神</p >
                                            <span class="button">开始游戏</span>
                                        </a>
                                    </li>
                                    <li class="scrollLoading" style="width: 130px;height: 168.44px">
                                        <a href="javascript:;" @if($_member) onclick="javascript:window.open('{{ route('ag.playGame') }}?id=525','','width=1024,height=768')" @else onclick="return alert('请先登录！')"  @endif>
                                            <img data-original="{{ asset('/web/images/games/ag/525.jpg')}}" class="lazy">
                                            <p class="collect">水上乐园</p >
                                            <span class="button">开始游戏</span>
                                        </a>
                                    </li>
                                    <li class="scrollLoading" style="width: 130px;height: 168.44px">
                                        <a href="javascript:;" @if($_member) onclick="javascript:window.open('{{ route('ag.playGame') }}?id=607','','width=1024,height=768')" @else onclick="return alert('请先登录！')"  @endif>
                                            <img data-original="{{ asset('/web/images/games/ag/607.jpg')}}" class="lazy">
                                            <p class="collect">小熊猫</p >
                                            <span class="button">开始游戏</span>
                                        </a>
                                    </li>



                                </ul>
                            </div>
                            <div class="egame_recommond">
                                {{--<div class="top_qrcode">--}}
                                {{--<div class="qrimg"><img src="{{ asset('/web/images/PT-APP.png') }}"></div>--}}
                                {{--<dl>--}}
                                {{--<dt>PT Android版</dt>--}}
                                {{--<dd>下载客户端，随时随地玩游戏,轻轻松松中大奖</dd>--}}
                                {{--</dl>--}}
                                {{--<a class="pc_download">PC客户端下载</a>--}}
                                {{--</div>--}}
                                <div class="hot_recommond">
                                    <h3><span class="tit">热门推荐</span></h3>
                                    <ul>
                                        <li class="on">
                                            <span class="index">
                                              1
                                            </span>
                                                                    <span class="gamepic">
                                              <img src="{{ asset('/web/images/fm.png') }}">
                                            </span>
                                            <dl>
                                                <dt>古怪猴子</dt>
                                                <dd class="star"><i class="iconfont">&#xe659;</i><i class="iconfont">
                                                        &#xe659;</i><i class="iconfont">&#xe659;</i><i class="iconfont">
                                                        &#xe659;</i><i class="iconfont">&#xe659;</i></dd>
                                                <dd class="gogame"><a href="#">进入游戏</a></dd>
                                            </dl>
                                        </li>
                                        <li>
                                                <span class="index">
                                                  1
                                                </span>
                                                <span class="gamepic">
                                                  <img src="{{ asset('/web/images/fm.png') }}">
                                                </span>
                                            <dl>
                                                <dt>古怪猴子</dt>
                                                <dd class="star"><i class="iconfont">&#xe659;</i><i class="iconfont">
                                                        &#xe659;</i><i class="iconfont">&#xe659;</i><i class="iconfont">
                                                        &#xe659;</i><i class="iconfont">&#xe659;</i></dd>
                                                <dd class="gogame"><a href="#">进入游戏</a></dd>
                                            </dl>
                                        </li>
                                        <li>
                    <span class="index">
                      1
                    </span>
                                            <span class="gamepic">
                      <img src="{{ asset('/web/images/fm.png') }}">
                    </span>
                                            <dl>
                                                <dt>古怪猴子</dt>
                                                <dd class="star"><i class="iconfont">&#xe659;</i><i class="iconfont">
                                                        &#xe659;</i><i class="iconfont">&#xe659;</i><i class="iconfont">
                                                        &#xe659;</i><i class="iconfont">&#xe659;</i></dd>
                                                <dd class="gogame"><a href="#">进入游戏</a></dd>
                                            </dl>
                                        </li>
                                        <li>
                    <span class="index">
                      1
                    </span>
                                            <span class="gamepic">
                      <img src="{{ asset('/web/images/fm.png') }}">
                    </span>
                                            <dl>
                                                <dt>古怪猴子</dt>
                                                <dd class="star"><i class="iconfont">&#xe659;</i><i class="iconfont">
                                                        &#xe659;</i><i class="iconfont">&#xe659;</i><i class="iconfont">
                                                        &#xe659;</i><i class="iconfont">&#xe659;</i></dd>
                                                <dd class="gogame"><a href="#">进入游戏</a></dd>
                                            </dl>
                                        </li>
                                        <li>
                    <span class="index">
                      1
                    </span>
                                            <span class="gamepic">
                      <img src="{{ asset('/web/images/fm.png') }}">
                    </span>
                                            <dl>
                                                <dt>古怪猴子</dt>
                                                <dd class="star"><i class="iconfont">&#xe659;</i><i class="iconfont">
                                                        &#xe659;</i><i class="iconfont">&#xe659;</i><i class="iconfont">
                                                        &#xe659;</i><i class="iconfont">&#xe659;</i></dd>
                                                <dd class="gogame"><a href="#">进入游戏</a></dd>
                                            </dl>
                                        </li>
                                        <li>
                    <span class="index">
                      1
                    </span>
                                            <span class="gamepic">
                      <img src="{{ asset('/web/images/fm.png') }}">
                    </span>
                                            <dl>
                                                <dt>古怪猴子</dt>
                                                <dd class="star"><i class="iconfont">&#xe659;</i><i class="iconfont">
                                                        &#xe659;</i><i class="iconfont">&#xe659;</i><i class="iconfont">
                                                        &#xe659;</i><i class="iconfont">&#xe659;</i></dd>
                                                <dd class="gogame"><a href="#">进入游戏</a></dd>
                                            </dl>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('web.layouts.aside')
    <div class="notice_layer">
        <h3>公告详情 <span class="close"></span></h3>
        <div class="notice_con">
            @foreach($system_notices as $v)
                <div class="module">
                    <h4>{{ $v->title }}</h4>
                    <p>✿{{ $v->content }}</p>
                </div>
            @endforeach
        </div>
    </div>
    <script>
        (function ($) {
            $(function () {
                $('.live-ul li').on('mouseenter', function () {
                    $(this).addClass('on').siblings('li').removeClass('on');
                });

                $('.egameslide').on('click', '.disabled', function () {
                    layer.msg('暂未开通，敬请期待！', {icon: 6});
                    return false;
                });
                jQuery(".egameslide").slide({trigger: "click", mainCell: ".bd"});


                $("img.lazy").lazyload({
                    placeholder: "{{ asset('/web/images/egame-loading.gif') }}",
                    effect: "fadeIn",
                    skip_invisible: false  //解决滚动才显示的问题
                });

                $('.hot_recommond li').on('mouseenter', function () {
                    $(this).addClass('on').siblings('li').removeClass('on');
                })

                //公告
                $('#mar0').on('click', function () {
                    var notice_index = layer.open({
                        type: 1,
                        title: false,
                        closeBtn: 0,
                        area: ['680px'],
                        skin: 'layui-layer-nobg', //没有背景色
                        shadeClose: true,
                        content: $('.notice_layer')
                    });

                    $('.notice_layer').on('click', '.close', function () {
                        layer.close(notice_index)
                    })
                })


            });


        })(jQuery)
    </script>
@endsection