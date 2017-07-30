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
            <span>绑定银行卡信息</span>
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
            <form action="{{ route('wap.post_bind_bank') }}" method="post" name="form1">
                <dl>
                    <dt>收款人信息</dt>
                    <dd>
                        <div class="pull-left">
                            会员账户
                        </div>
                        <div class="pull-right">
                            {{ $_member->name }}
                        </div>
                    </dd>
                    <dd>
                        <div class="pull-left">收款人姓名</div>
                        <div class="pull-right">{{ $_member->real_name }}</div>
                    </dd>
                </dl>
                <dl class="set_card">
                    <dt>
                        设置银行卡信息 <br>
                        <span><em>*</em>设置后将无法修改信息，请核实后填写</span>
                    </dt>
                    <dd>
                        <div class="pull-left">
                            收款银行
                        </div>
                        <select class="select" name="bank_name">
                            <option value="">--请选择--</option>
                            @foreach(\App\Models\Base::$BANK_TYPE as $v)
                                <option value="{{ $v }}" @if($_member->bank_name == $v) selected @endif>{{ $v }}</option>
                            @endforeach
                        </select>
                    </dd>
                    <dd>
                        <div class="pull-left">银行账号</div>
                        <input id="pay_num" class="pull-left" type="number" placeholder="银行账号" name="bank_card">
                    </dd>
                    <dd>
                        <div class="pull-left">开户行地址</div>
                        <input id="pay_address" class="pull-left" type="text" placeholder="开户行地址" name="bank_address">
                    </dd>
                    <dd>
                        <input type="button" value="确定" class="submit_btn ajax-submit-btn">
                    </dd>
                </dl>
            </form>
            <div style="padding: 20px">
                <span class="c_blue">注意事项：</span><br>
                1、银行账户持有人姓名必须与注册时输入的姓名一致，否则无法申请提款。<br>
                2、每位客户只可以使用一张银行卡进行提款，如需要更换银行卡请与客服人员联系；否则提款将被拒绝。<br>
                3、为保障客户资金安全，{{ $_system_config->site_name }}有可能需要用户提供电话单，银行对账单或其它资料验证，以确保客户资金不会被冒领。
            </div>
        </div>
    </div>
@endsection