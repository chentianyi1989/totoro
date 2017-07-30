@extends('web.layouts.main')
@section('content')
    <div class="body clear">
        <div class="pro-nr-bg">
            <div class="container">
                <div class="pro-xq">
                    <div>
                        <div class="pro-xq-bt">
                            <h2>信息认证红利 完成个人信息验证就能轻轻松松领礼金！</h2>
                            <span>时间：永久有效</span>
                        </div>
                        <div class="pro-cont">
                            <h1>什么是信息认证红利？</h1>
                            <p>
                                信息认证红利是会员完成通过相关的条件后，系统给予的现金奖励。用户可到“个人中心”的“自助优惠”页面申领
                                <b class="red">
                                    <em>38元</em>
                                </b>
                                认证礼金。
                            </p>
                            <h1>信息认证红利领取条件</h1>
                            <ul class="tbpro-lqlc clear">
                                <li class="tbpro-lqlc-li">完成手机验证</li>
                                <li class="tbpro-lqlc-li2">&nbsp;</li>
                                <li class="tbpro-lqlc-li">完成银行卡验证</li>
                                <li class="tbpro-lqlc-li2">&nbsp;</li>
                                <li class="tbpro-lqlc-li">完成安全密码验证</li>
                                <li class="tbpro-lqlc-li2">&nbsp;</li>
                                <li class="tbpro-lqlc-li">历史累计存款不小于200元</li>
                            </ul>
                            <h1>活动细则</h1>
                            <ol class="rules-ol">
                                <li>用户必须完成通过所有认证以及历史累计存款不小于200元后，才达到申领条件。如其中一个未完成，就无法领取礼金。</li>
                                <li>所有客户只能拥有一个账号：同一个IP、同一个存/提款卡、同一个手机号码、同一个邮箱都视为同一客户，如果发现同一个人拥有两个或以上的账户，重复的账户将会被冻结，【{{ $_system_config->site_name }}】保留索回重复账户的红利 及盈利的权利。</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection