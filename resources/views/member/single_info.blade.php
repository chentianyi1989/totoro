@extends('member.layouts.main')
@section('content')
<div class="userbasic_head">
    <a href="{{ route('member.userCenter') }}" class="active">基本信息</a>
    <a href="{{ route('member.bank_load') }}">银行资料</a>
    {{--<a href="{{ route('member.account_load') }}">账户设置</a>--}}
    <a href="{{ route('member.message_list') }}">站内消息</a>
</div>
<div class="userbasic_con" style="padding-top:0">
    <div class="bank_tips">温馨提示：手机验证后，可自行修改银行相关信息（开户姓名无法修改;绑定的银行卡必须和注册绑定姓名一致，否则无法提款!）</div>
    <div class="basic_module">
        <div class="basic_left">
            <p class="tips">您好，<span class="name">{{ $_member->name }}</span><span class="level_img"><img src="{{ asset('/web/images/live-ico.png') }}"></span></p>
            <p class="level_tips">您的账户安全等级：<span class="level_line"><span class="level" levelNum='30%'></span></span>低 <a class="change_psw" href="{{ route('member.login_psw') }}">更换密码</a></p>
            <div class="basic_modify">
                {{--<a href="javascript:void(0)" _href="safe_manage.html"><i class="iconfont ">&#xe60c;</i>手机验证</a>--}}
                {{--<a href="javascript:void(0)" _href="safe_manage.html"><i class="iconfont ">&#xe60c;</i>邮箱验证</a>--}}
                {{--<a href="javascript:void(0)" _href="safe_psw.html"><i class="iconfont ">&#xe60c;</i>安全密码</a>--}}
                <a href="{{ route('member.bank_load') }}" class="after"><i class="iconfont ">&#xe649;</i>绑定银行卡</a>
            </div>
        </div>
        <div class="basic_right">
            <p class="tips">会员VIP等级</p>
            <p class="level_tips"><span class="member_wrap">普通会员</span><span class="level_line"></span><span class="member_wrap vp">普通VIP</span></p>
            <p class="vip_tips">首存任意金额自动升级为<span class="themeCr">普通VIP</span>，享受<span class="themeCr">0.8%</span>洗码返利！</p>
        </div>
    </div>
</div>
<ul class="gameroom_list">
        <?php
            $own_api_list = $_member->apis()->pluck('api_id')->toArray();
        ?>
        @foreach($api_list as $item)
            <?php
                $mod = '';
                if (in_array($item->id, $own_api_list))
                        $mod = $_member->apis()->where('api_id', $item->id)->first();
                ?>
        <li>
            <p class="name">{{ $item->api_name }}厅 <span class="pos">@if($mod) {{ $mod->money }}  @else N/A @endif</span><a class="refresh" href="javascript:void(0)" data-uri="{{ route('member.api.check') }}?api_name={{ $item->api_name }}"></a></p>
            <p class="account">游戏账号：<span class="viceColor" data-username="{{ $item->prefix.$_member->name }}">@if($mod) {{ $item->prefix.$_member->name  }}  @else 未开通 @endif</span></p>
        </li>
        @endforeach

</ul>
<div class="basic_info">
    <h3 class="head_line">
        <span class="tit">个人资料</span>
    </h3>
    <ul class="list">
        <li>
            <span class="title">性别</span>
            @if($_member->gender ==0)男@else女@endif
        </li>
        <li>
            <span class="title">联系地址</span>
            中国湖北武汉
        </li>
        <li>
            <span class="title">联系电话</span>
            {{ $_member->phone }}
        </li>
        <li>
            <span class="title">邮箱地址</span>
            {{ $_member->email }}
        </li>
        <li>
            <span class="title">联系QQ</span>
            {{ $_member->qq }}
        </li>
        <li>
            <span class="title">我的推荐人</span>
            {{ $_member->top_member->name or '' }}
        </li>
    </ul>
</div>
<script>
    $(function(){
        $('.refresh').on('click',function(){
            var _this=$(this);
            var pos = _this.parent('p').find('span');
            var money_span = _this.parent('p').next().find('span');
            _this.css({
                'background':'url({{ asset("/web/images/h-u-loading2.gif") }}) no-repeat center center'
            })
            $.ajax({
                type : 'GET',
                url : _this.attr('data-uri'),
                data : '',
                contentType : "application/json; charset=utf-8",
                success : function(data){

                    _this.css({
                        'background':'url({{ asset("/web/images/bg-ico.png") }}) no-repeat center center',
                        'background-position': '-80px -102px'
                    })
                    if (data.Code != 0)
                    {
                        alert(data.Message);
                        return ;
                    }
                    pos.html(data.Data+'元');
                    money_span.html(money_span.attr('data-username'))
                    //console.log(data)
                },
                error: function (err, status) {
                    console.log(err)
                }
            })
        })

        $('.level').each(function(){
            var levelNum=$(this).attr('levelNum');
            $(this).animate({
                'width':levelNum
            },800)
        })
    })
</script>
@endsection