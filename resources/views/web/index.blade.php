@extends('web.layouts.main')
@section('after.js')
    <script type="text/javascript">

        if(/AppleWebKit.*mobile/i.test(navigator.userAgent) || (/MIDP|SymbianOS|NOKIA|SAMSUNG|LG|NEC|TCL|Alcatel|BIRD|DBTEL|Dopod|PHILIPS|HAIER|LENOVO|MOT-|Nokia|SonyEricsson|SIE-|Amoi|ZTE/.test(navigator.userAgent))){

            if(window.location.href.indexOf("?mobile")<0){

                try{

                    if(/Android|webOS|iPhone|iPod|BlackBerry/i.test(navigator.userAgent)){

                        window.location.href="http://m.mxxfun.com";

                    }else if(/iPad/i.test(navigator.userAgent)){

                        window.location.href="http://m.mxxfun.com";

                    }else{

                        window.location.href="http://m.mxxfun.com"

                    }

                }catch(e){}

            }

        }

    </script>
    @endsection
@section('content')
<div class="body" style="overflow: hidden">
    <div class="banner flexslider">
        <ul class="slides">
            <li><img src="{{ asset('/web/images/xierdun/banner01.jpg') }}"/></li>
            <li><img src="{{ asset('/web/images/xierdun/banner02.jpg') }}"/></li>
            <li><img src="{{ asset('/web/images/xierdun/banner03.jpg') }}"/></li>
            <li><img src="{{ asset('/web/images/xierdun/banner04.jpg') }}"/></li>
        </ul>
    </div>

    <div class="marquee">
        <div class="container">
            <div class="pullLeft">最新公告：</div>
            <marquee class="pullRight" id="mar0" scrollAmount="2" direction="left" onmouseout="this.start()" onmouseover="this.stop()">
                @foreach($system_notices as $v)
                    <span>~{{ $v->title }}~</span>
                    <span>{{ $v->content }}</span>
                @endforeach
            </marquee>
        </div>
    </div>

    <div class="page-container">
        <div class="container">
            <div class="first-game">
                <a href="{{ route('web.liveCasino') }}" class="game_1"></a>
                <a href="{{ route('web.lottory') }}" class="game_2"></a>
                <a href="{{ route('web.egame') }}" class="game_3"></a>
                <a href="{{ route('web.esports') }}" class="game_4"></a>
            </div>
            <div class="max-btn">
                <div class="bb-btn-box">
                    <a class="bbin-btn" href="javascript:;"></a>
                    <a class="mg-btn" href="javascript:;"></a>
                    <a class="gns-btn" href="javascript:;"></a>
                </div>
            </div>
            <div class="mobile-bg">
                <a href="" class="mobile-btn"></a>
                <img class="mobile-erweima" src="{{ asset('/web/images/xierdun/erweima.png') }}" alt="">
            </div>
        </div>
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
    </div>
</div>
<script>
    $(function(){
        $('.show-cate').click(function(){
            var url = $(this).attr('data-uri');
            layer.open({
                type: 2,
                title: '记录',
                shadeClose: false,
                shade: 0.8,
                area: ['90%', '90%'],
                content: url
            });
        })
    });
</script>
<script>


    (function ($) {
        $(function () {
            $('.flexslider').flexslider({
                animation: 'fade',
                directionNav: false
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
            })


            //superslide
           /* jQuery(".txtScroll-top").slide({mainCell:".bd ul",autoPage:true,effect:"top",autoPlay:true,vis:9,pnLoop:true});*/

           //superslide
           var listMarqueIndex=0;
           var listMarqueShow=7;  //要显示的个数
           var listMarqueLength=$('.txtScroll-top .ntb-egzj li').length;  //总共显示的条数
            console.log(listMarqueLength);
           if(listMarqueLength>listMarqueShow){  //大于要显示的个数才执行动画
            var listMarque=setInterval(function(){

                console.log(listMarqueIndex);
                if(listMarqueLength-listMarqueIndex>listMarqueShow){
                    listMarqueIndex++;
                    $('.txtScroll-top .ntb-egzj li').removeClass('on')
                    $('.txtScroll-top .ntb-egzj li').eq(listMarqueIndex).addClass('on');
                    $('.txtScroll-top .ntb-egzj').animate({
                    "top":"-=45px"
                   },800);
                }else{
                    $('.txtScroll-top .ntb-egzj').animate({"top":'0'})
                    listMarqueIndex=0;
                    $('.txtScroll-top .ntb-egzj li').removeClass('on')
                    $('.txtScroll-top .ntb-egzj li').eq(listMarqueIndex).addClass('on')
                }
               },4000);
           }

            $('.disabled').on('click',function(){
                layer.msg('暂未开放，敬请期待',{icon:6});
            });
           
        })
    })(jQuery)
</script>
<script id="jsID" type="text/javascript">

</script>
@endsection
