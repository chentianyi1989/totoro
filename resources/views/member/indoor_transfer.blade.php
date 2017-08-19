@extends('member.layouts.main')
@section('content')
<div class="userbasic_head">
    <a href="{{ route('member.finance_center') }}">会员存款</a>
    <a href="{{ route('member.member_drawing') }}">会员提款</a>
    <a href="{{ route('member.indoor_transfer') }}"  class="active">户内转账</a>
    {{--<a href="{{ route('member.finance_center') }}">自助入账</a>--}}
</div>
<div class="userbasic_body">
    <form action="{{ route('member.post_transfer') }}" method="post">
    <div class="bank_tips">温馨提示：查询时，请点击游戏厅刷新额度</div>
    <div class="indoor_line">
        <h3><span class="tit">选择账户</span><span class="themeCr"> (请选择对应转账账户，若从平台转出金额，则默认转出至主账户)</span></h3>
        <ul class="gameroom_list indoor_toplist">
            <li data-type="1">
                <p class="transfer_tit"> 主账户额度</p>
                <p class="name">￥<span class="pos">{{ $_member->money }}</span>&nbsp;元</p>
                 <em></em>
            </li>
            <li data-type="2">
                <p class="transfer_tit"> 红利账户额度</p>
                <p class="name">￥<span class="pos">{{ $_member->fs_money }}</span>&nbsp;元</p>
                 <em></em>
            </li>
            
            <input type="hidden" name="account1" value="1">
            
        </ul>
    </div>
    <div class="indoor_line">
        <h3><span class="tit">选择游戏平台</span></h3>
        <ul class="gameroom_list game_platform">
            <?php
            $own_api_list = $_member->apis()->pluck('api_id')->toArray();
            ?>
            @foreach($api_list as $item)
                <?php
                $mod = '';
                if (in_array($item->id, $own_api_list))
                    $mod = $_member->apis()->where('api_id', $item->id)->first();
                ?>
                
                {{--<li>--}}
                    {{--<p class="name">{{ $item->api_name }}厅 <span class="pos">@if($mod) {{ $mod->money }}  @else N/A @endif</span><a class="refresh" href="javascript:;" data-uri="{{ route('member.api.check') }}?api_name={{ $item->api_name }}"></a></p>--}}
                    {{--<p class="account">游戏账号：<span class="viceColor" data-username="{{ $item->prefix.$_member->name }}">@if($mod) {{ $mod->username }}  @else 未开通 @endif</span></p>--}}
                {{--</li>--}}

                    <li class="hasnotinfo" data-id="{{ $item->id }}">
                        <p class="name">{{ $item->api_name }}厅 <span class="pos">@if($mod) {{ $mod->money }}元  @else N/A @endif</span><a href="javascript:;" class="refresh" data-uri="{{ route('member.api.check') }}?api_name={{ $item->api_name }}"></a></p>
                        <em></em>
                    </li>
            @endforeach


             {{--<li  class="hasnotinfo">--}}
                {{--<p class="name">PT厅 <span class="pos">N/A</span><a class="refresh" href="javascript:void(0)"></a></p>--}}
                {{--<em></em>--}}
              {{--</li>--}}
              {{--<li class="hasinfo">--}}
                {{--<p class="name">MG国际厅 <span class="pos">N/A</span><a class="refresh" href="javascript:void(0)"></a></p>--}}
                {{--<em></em>--}}
              {{--</li>--}}
              {{--<li  class="hasinfo">--}}
                {{--<p class="name">MG厅 <span class="pos">N/A</span><a class="refresh" href="javascript:void(0)"></a></p>--}}
                {{--<em></em>--}}
              {{--</li>--}}
              {{--<li  class="hasnotinfo">--}}
                {{--<p class="name">波音厅 <span class="pos">N/A</span><a class="refresh" href="javascript:void(0)"></a></p>--}}
                {{--<em></em>--}}
              {{--</li>--}}
              <input type="hidden" name="account2">
        </ul>
    </div>
    <div class="indoor_line dividend_bonus">
        <h3><span class="tit">转账红利</span></h3>
        <!-- <dl>
            <dt><img src="{{ asset('/web/images/indoorIcon1.jpg') }}">MG老虎机账户首存送100%红利</dt>
        </dl>
        <dl>
            <dt><img src="{{ asset('/web/images/indoorIcon1.jpg') }}">MG老虎机每日首存送50%红利</dt>
        </dl>
        <dl>
            <dt><img src="{{ asset('/web/images/indoorIcon1.jpg') }}">MG老虎机笔笔存送30%红利</dt>
        </dl>
        <dl>
            <dt><img src="{{ asset('/web/images/indoorIcon2.jpg') }}">下次参与</dt>
            <dd>直接转入游戏<span class="themeCr">0</span>元红利，并锁定此游戏转账通道，需要达到100流水或游戏账户小于<span class="themeCr">1</span>元解锁转账通道。</dd>
        </dl> -->

        <dl>
          <dt><input type="radio" class="radio" name="1" id="dividend_bonus1"><label for="dividend_bonus1">MG老虎机账户首存送100%红利</label></dt>
        </dl>
        <dl>
          <dt><input type="radio" class="radio" name="1" id="dividend_bonus2"><label for="dividend_bonus2">MG老虎机每日首存送50%红利</label></dt>
        </dl>
        <dl>
          <dt><input type="radio" class="radio" name="1"  id="dividend_bonus3"><label for="dividend_bonus3">MG老虎机笔笔存送30%红利</label></dt>
        </dl>
        <dl>
          <dt><input type="radio" class="radio" name="1"  id="dividend_bonus4"><label for="dividend_bonus4">下次参与</label></dt>
          <dd>直接转入游戏<span class="themeCr">0</span>元红利，并锁定此游戏转账通道，需要达到100流水或游戏账户小于<span class="themeCr">1</span>元解锁转账通道。</dd>
        </dl>
    </div>
    <div class="indoor_line">
        <h3><span class="tit">转账额度</span></h3>
        <div class="line_form">
            <div class="line">
                <input type="number" class="inp" name="money">
                <span class="tips"><span class="themeCr"></span>元</span>
            </div>
            <div class="line">
                <button type="button" class="account_save" data-type="0">转入游戏平台</button>
                <button class="indoor_main" data-type="1" type="button">转出游戏平台</button>
                <input type="hidden" name="transfer_type" value="0">
            </div>
        </div>
    </div>
    </form>
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
                    //money_span.html(money_span.attr('data-username'))
                    //console.log(data)
                },
                error: function (err, status) {
                    //console.log(err)
                }
            })
        });

        //选择账户
        $('.indoor_toplist').on('click','li',function(){
            var _index=$(this).index();
            //隐藏的input 值
            $('.indoor_toplist li').removeClass('on');
            $(this).addClass('on');
            $('input',$(this).parent()).val($(this).attr('data-type'));
        })

        //选择游戏平台
        $('.game_platform').on('click','li.hasinfo',function(){
            $('.game_platform li').removeClass('on');
            $(this).addClass('on');
            $('.dividend_bonus').show();

            //隐藏的input 值
            $('input',$(this).parent()).val($(this).attr('data-id'));
        })

        $('.game_platform').on('click','li.hasnotinfo',function(){
            $('.game_platform li').removeClass('on');
            $(this).addClass('on');
            $('.dividend_bonus').hide();

            //隐藏的input 值
            $('input',$(this).parent()).val($(this).attr('data-id'));
        })

        //转入游戏平台按钮 改变隐藏的input 值
        $('.line_form .account_save,.line_form .indoor_main').on('click',function(){
            var btn = $(this)
            $('input',btn.parent()).val(btn.attr('data-type'));

            btn.attr('disabled', true);

            var go = true;
            var form = $(this).parents('form');

            var url = form.attr('action');
            var method = form.attr('method');

            var rest_method = form.find("input[name='_method']");
            var method_s = rest_method.length > 0 ? rest_method.val() : method;
            if (go == true)
            {
                var detailLoad = layer.load(2, {
                    shade: [0.2, '#ccc'], //遮罩层背景色、透明度,
                    //shade:false
                });

                $.ajax({
                    type: method_s,
                    url: url,
                    data: form.serialize(),
                    dataType: "json",
                    success: function(data){
                        layer.close(detailLoad);
                        btn.attr('disabled', false);

                        var html = '';
                        var obj = JSON.parse (data.status.msg);

                        for ( var p in obj )
                        {
                            if (typeof (obj[p]) == 'string')
                            {
                                html+= '<p><b>'+ obj[p] + '</b></p>';
                            } else if(obj[p] instanceof Array)
                            {
                                for (var i=0;i<obj[p].length;i++)
                                {
                                    html+= '<p><b>'+ obj[p][i] + '</b></p>';
                                }

                            }
                        }
                        //
                        layer.confirm(html, {
                            btn: ['确定'] //按钮
                        });
                        if (data.url)
                            location.href=data.url;
                        //else
                        //    layer.confirm(html, {
                        //        btn: ['确定'] //按钮
                        //    });

                    }
                });
            }
        })

        
    })
</script>
    @endsection
