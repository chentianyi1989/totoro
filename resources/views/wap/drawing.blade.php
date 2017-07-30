@extends('wap.layouts.main')
@section('content')
    <div class="container-fluid gm_main">
        <div class="head">
            <a class="f_l" href="javascript:history.go(-1)"><img src="{{ asset('/wap/images/user_back.png') }}" alt=""></a>
            <span>在线提款</span>
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

        <div class="userInfo">
            <form action="{{ route('wap.post_drawing') }}" method="post" name="form1">
                <dl>
                    <dt>账户信息</dt>
                    <dd>
                        <div class="pull-left">
                            用户账号
                        </div>
                        <div class="pull-right">
                            {{ $_member->name }}
                        </div>
                    </dd>
                    <dd>
                        <div class="pull-left">可用提款额度</div>
                        <div class="pull-right">{{ $_member->money }}元</div>
                    </dd>
                    <dd>
                        <div class="pull-left">收款人姓名</div>
                        <div class="pull-right">{{ $_member->real_name }}</div>
                    </dd>
                    <dd>
                        <div class="pull-left">收款银行</div>
                        <div class="pull-right">{{ $_member->bank_name }}</div>
                    </dd>
                    <dd>
                        <div class="pull-left">收款账号</div>
                        <div class="pull-right">{{ $_member->bank_card }}</div>
                    </dd>
                    <dd>
                        <div class="pull-left">收款银行地址</div>
                        <div class="pull-right">{{ $_member->bank_address }}</div>
                    </dd>
                </dl>
                <dl class="set_card">
                    <dt>发起提款申请</dt>
                    <dd>
                        <div class="pull-left">
                            提款金额
                        </div>
                        <input class="pull-left" type="number" placeholder="请输入提款金额" name="money" id="pay_value"  maxlength="10">

                    </dd>
                    <dd>
                        <div class="pull-left">
                            提款密码
                        </div>
                        <input class="pull-left" type="password" placeholder="请输入提款密码" name="qk_pwd" id="qk_pwd" maxlength="6" >
                    </dd>
                    <dd>
                        <input type="button" value="申请提款" class="submit_btn ajax-submit-btn">
                    </dd>
                </dl>
            </form>
        </div>
    </div>
@endsection