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
            <span>额度转换</span>
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
        <div class="userInfo setCard">
            <dl>
                <dt>账户信息</dt>
                <dd>
                    <div class="pull-left">
                        会员账户
                    </div>
                    <div class="pull-right">
                        {{ $_member->name }}
                    </div>
                </dd>
                <dd>
                    <div class="pull-left">中心账户余额</div>
                    <div class="pull-right">
                        {{ $_member->money }}元
                    </div>
                </dd>
                <dd>
                    <div class="pull-left">反水账户余额</div>
                    <div class="pull-right">
                        {{ $_member->fs_money }}元
                    </div>
                </dd>
                <?php
                $own_api_list = $_member->apis()->pluck('api_id')->toArray();
                ?>
                @foreach($_api_list as $k => $v)
                    <?php
                    $mod = '';
                    if (in_array($k, $own_api_list))
                        $mod = $_member->apis()->where('api_id', $k)->first();
                    ?>
                    <dd>
                        <div class="pull-left">{{ $v }}余额</div>
                        <div class="pull-right">
                            {{ $mod?$mod->money:'未开通' }} <a href="javascript:;"  class="api_check" data-uri="{{ route('member.api.check') }}?api_name={{ $v }}"><img src="{{ asset('/wap/images/user_refresh.png') }}" alt=""></a>
                        </div>
                    </dd>
                @endforeach
            </dl>
            <form id="form1" name="form1" class="form-horizontal" action="{{ route('wap.post_transfer') }}" method="post">

                <dl class="set_card">
                    <dt>账户安全</dt>
                    <dd>
                        <div class="pull-left">
                            转出账户
                        </div>
                        <select name="out_account" id="out_account" class="form-control">
                            <option value="">--请选择--</option>
                            <option value="1">中心账户</option>
                            <option value="2">返水账户</option>
                            @foreach($_api_list as $k => $v)
                                <option value="{{ $k }}">{{ $v }}</option>
                            @endforeach
                        </select>
                    </dd>
                    <dd>
                        <div class="pull-left">
                            转入账户
                        </div>
                        <select name="in_account" id="in_account" class="form-control">
                            <option value="">--请选择--</option>
                            <option value="1">中心账户</option>
                            @foreach($_api_list as $k => $v)
                                <option value="{{ $k }}">{{ $v }}</option>
                            @endforeach
                        </select>
                    </dd>
                    <dd>
                        <div class="pull-left">
                            转账金额
                        </div>
                        <input class="pull-left" type="number" placeholder="最少 5 元" name="money" id="zz_money">
                    </dd>
                    <dd>
                        <input type="button" value="提交" class="submit_btn ajax-submit-btn">
                    </dd>
                </dl>
            </form>

        </div>

        <script>


            $('.api_check').each(function(){
                var a = $(this);
                var url = a.attr('data-uri');
                $.get(url, function (data) {
                    //data = JSON.parse(data)
                    a.html(data.Data);
                });
            })

            {{--var ag_balance = $('#AG_balance');--}}
            {{--var mg_balance = $('#MG_balance');--}}
            {{--var url = "{{ route('member.api.check') }}";--}}
            {{--$.get(url+'api_name=AG', function (data) {--}}
                {{--data = JSON.parse(data)--}}
                {{--$('#bbin_money').html(data.general);--}}
            {{--});--}}
//            $.get('/newmg2/cha.php', function (data) {
//                data = JSON.parse(data)
//                $('#mg_money').html(data.general);
//            });
//            $.get('/newallbet2/cha.php',function(data){
//                data = JSON.parse(data)
//                $('#allbet_money').html(data.general);
//            });
        </script>
    </div>
@endsection