@extends('member.layouts.main')
@section('content')
    <div class="userbasic_head">
        <a href="{{ route('member.finance_center') }}" class="active">会员存款</a>
        <a href="{{ route('member.member_drawing') }}" >会员提款</a>
        <a href="{{ route('member.indoor_transfer') }}">户内转账</a>
        {{--<a href="{{ route('member.finance_center') }}">自助入账</a>--}}
    </div>

    <!--第二个页面开始-->
    <div class="userbasic_body">
        <div class="bank_tips">温馨提示: 如当前支付方式未能支付成功，请您尝试其他支付方式进行支付！</div>
        <div class="pay_way_wrap">
            <form action="{{ route('pay') }}" method="post">
                {!! csrf_field() !!}
                <div class="pay_way_line">
                    <div class="tit">选择银行</div>
                    <div class="con">
                        <ul class="bank-list">
                            <li>
                                <input name="bankId" type="radio" value="ICBC" checked >
                                <img src="{{ asset('/web/images/bank/gsyh.gif') }}" alt="工商银行" />
                                <input name="bankId" type="radio" value="CMB">
                                <img src="{{ asset('/web/images/bank/zsyh.gif') }}" alt="招商银行" />
                                <input name="bankId" type="radio" value="CCB">
                                <img src="{{ asset('/web/images/bank/jsyh.gif') }}" alt="建设银行" />
                                <input name="bankId" type="radio" value="COMM">
                                <img src="{{ asset('/web/images/bank/jtyh.gif') }}" alt="交通银行" />
                            </li>
                            <li>
                                <input name="bankId" type="radio" value="ABC">
                                <img src="{{ asset('/web/images/bank/nyyh.gif') }}" alt="农业银行" />
                                <input name="bankId" type="radio" value="BOC">
                                <img src="{{ asset('/web/images/bank/zgyh.gif') }}" alt="中国银行" />
                                <input name="bankId" type="radio" value="CIB">
                                <img src="{{ asset('/web/images/bank/xyyh.gif') }}" alt="兴业银行" />
                                <input name="bankId" type="radio" value="SPDB">
                                <img src="{{ asset('/web/images/bank/pdfzyh.gif') }}" alt="浦发银行" />
                            </li>
                            <li>
                                <input name="bankId" type="radio" value="CMBC">
                                <img src="{{ asset('/web/images/bank/msyh.gif') }}" alt="民生银行" />
                                <input name="bankId" type="radio" value="CNCB">
                                <img src="{{ asset('/web/images/bank/zxyh.gif') }}" alt="中信银行" />
                                <input name="bankId" type="radio" value="CEB">
                                <img src="{{ asset('/web/images/bank/gdyh.gif') }}" alt="光大银行" />
                                <input name="bankId" type="radio" value="HXB">
                                <img src="{{ asset('/web/images/bank/hxyh.gif') }}" alt="华夏银行" />
                            </li>
                            <li>
                                <input name="bankId" type="radio" value="PSBC">
                                <img src="{{ asset('/web/images/bank/yzcxyh.gif') }}" alt="邮政储蓄银行" />
                                <input name="bankId" type="radio" value="CGB">
                                <img src="{{ asset('/web/images/bank/gdfzyh.gif') }}" alt="广发银行" />
                                <input name="bankId" type="radio" value="PAB">
                                <img src="{{ asset('/web/images/bank/payh.gif') }}" alt="平安银行" />
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="pay_way_line">
                    <div class="tit">转账金额</div>
                    <div class="con">
                        <p><input type="text" class="inp" name="amount" required> 元</p>
                    </div>
                </div>
                <div class="pay_way_line">
                    <div class="tit"></div>
                    <div class="con">
                        <button type="submit" class="account_save">提 交</button> <a href="{{ route('member.finance_center') }}" class="account_save">返回</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('after.js')
@endsection
