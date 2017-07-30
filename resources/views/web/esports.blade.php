@extends('web.layouts.main')
@section('content')

    <div class="body"
         style="background: url('{{ asset('/web/images/egame-banner-esports.jpg') }}') no-repeat;">
        <div class="container tbbg-margin" style="padding-top: 380px;">
            {{--<div class="notice clear" style="margin-top:-220px">--}}
            {{--<div class="notice-bg"></div>--}}
            {{--<div class="notice-title pullLeft">--}}
            {{--<div class="notice-title_bg"></div>--}}
            {{--<span class="bg-icon pullLeft"></span>--}}
            {{--系统公告--}}
            {{--</div>--}}
            {{--<marquee id="mar0" scrollAmount="4" direction="left" onmouseout="this.start()"--}}
            {{--onmouseover="this.stop()">--}}
            {{--@foreach($system_notices as $v)--}}
            {{--<span>~{{ $v->title }}~</span>--}}
            {{--<span>{{ $v->content }}</span>--}}
            {{--@endforeach--}}
            {{--</marquee>--}}
            {{--</div>--}}
            <div class="ele-live-wrap">
                <div class="ele-live-main-wrap clear">
                    <div class="ele-live-bbin-wrap">
                        <a class="ele-link-bbin" href="javascript:;" @if($_member) onclick="javascript:window.open('{{ route('bbin.playGame') }}?pageSite=ball','','width=1024,height=768')"
                           @else onclick="return alert('请先登录！')" @endif>
                            <img class="ele-img-hover-effect ele-img-default" src="{{ asset('/web/images/bb_tiyu_big.png') }}" alt="">
                            <img class="ele-img-hover-effect ele-img-active" src="{{ asset('/web/images/bb_tiyu_big_h.png') }}" alt="">
                        </a>
                        <div class="ele-live-bbin-inner">
                            <!--<div class="ele-bbin-links-wrap">-->
                            <!--<a class="bbin-livehall bbin-livehall-40" href="javascript:;">-->
                            <!--<div class="ele-icon-bbin"></div>-->
                            <!--<div class="ele-bbin-name">多台下注</div>-->
                            <!--</a>-->
                            <!--</div>-->
                            <a href="javascript:;" class="ele-btn-play" @if($_member) onclick="javascript:window.open('{{ route('bbin.playGame') }}?pageSite=ball','','width=1024,height=768')"
                               @else onclick="return alert('请先登录！')" @endif></a>
                        </div>
                    </div>
                    <div class="ele-live-slider-wrap">
                        <a href="javascript:;" @if($_member) onclick="javascript:window.open('{{ route('bbin.playGame') }}?pageSite=ball','','width=1024,height=768')"
                           @else onclick="return alert('请先登录！')" @endif>
                            <img src="{{ asset('/web/images/bb_tiyu.png') }}" alt="">
                        </a>
                    </div>
                </div>
                {{--<div class="ele-live-default-wrap clear">--}}
                {{--<div class="livehall-row">--}}
                {{--<a href="javascript:;" class="livehall-playnow livehall-playnow-ag ">--}}
                {{--<img class="img-web ele-img-hover-effect ele-img-default" src="{{ asset('/web/images/ag_m_n.png') }}" alt="">--}}
                {{--<img class="img-web ele-img-hover-effect ele-img-active" src="{{ asset('/web/images/ag_m_h.png') }}" alt="">--}}
                {{--</a>--}}
                {{--</div>--}}
                {{--<div class="livehall-row">--}}
                {{--<a href="javascript:;" class="livehall-playnow livehall-playnow-ag ">--}}
                {{--<img class="img-web ele-img-hover-effect ele-img-default" src="{{ asset('/web/images/allbet_m_n.png') }}" alt="">--}}
                {{--<img class="img-web ele-img-hover-effect ele-img-active" src="{{ asset('/web/images/allbet_m_h.png') }}" alt="">--}}
                {{--</a>--}}
                {{--</div>--}}
                {{--<div class="livehall-row">--}}
                {{--<a href="javascript:;" class="livehall-playnow livehall-playnow-ag ">--}}
                {{--<img class="img-web ele-img-hover-effect ele-img-default" src="{{ asset('/web/images/og_m_n.png') }}" alt="">--}}
                {{--<img class="img-web ele-img-hover-effect ele-img-active" src="{{ asset('/web/images/og_m_h.png') }}" alt="">--}}
                {{--</a>--}}
                {{--</div>--}}
                {{--<div class="livehall-row">--}}
                {{--<a href="javascript:;" class="livehall-playnow livehall-playnow-ag ">--}}
                {{--<img class="img-web ele-img-hover-effect ele-img-default" src="{{ asset('/web/images/gd_m_n.png') }}" alt="">--}}
                {{--<img class="img-web ele-img-hover-effect ele-img-active" src="{{ asset('/web/images/gd_m_h.png') }}" alt="">--}}
                {{--</a>--}}
                {{--</div>--}}
                {{--</div>--}}
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

                $('.egameslide').on('click','.disabled',function(){
                    layer.msg('暂未开通，敬请期待！',{icon:6});
                    return false;
                });
                jQuery(".egameslide").slide({trigger: "click", mainCell: ".bd"});


                $("img.lazy").lazyload({
                    placeholder: "{{ asset('/web/images/egame-loading.gif') }}",
                    effect: "fadeIn",
                    skip_invisible: false  //解决滚动才显示的问题
                });

                $('.hot_recommond li').on('mouseenter',function(){
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