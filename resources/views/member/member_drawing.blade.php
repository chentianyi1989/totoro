@extends('member.layouts.main')
@section('content')
<div class="userbasic_head">
    <a href="{{ route('member.finance_center') }}">会员存款</a>
    <a href="{{ route('member.member_drawing') }}"  class="active">会员提款</a>
    <a href="{{ route('member.indoor_transfer') }}">户内转账</a>
    {{--<a href="{{ route('member.finance_center') }}">自助入账</a>--}}
</div>
<div class="userbasic_body">
    <div class="bank_tips">温馨提示：每日提款限制3次，每次限额不得超过20W，提款操作完成后，请联系客服核对信息，以免出错！</div>
    <div class="line_form">
        <form action="{{ route('member.drawing') }}" method="post">
            <div class="line">
                <span class="tit">开户姓名</span>
                {{ $_member->bank_username }}
            </div>
            <div class="line">
                <span class="tit">收款银行</span>
                {{ $_member->bank_name }}
            </div>
            <div class="line">
                <span class="tit">银行账号</span>
                {{ $_member->bank_card }}
            </div>
            <div class="line">
                <span class="tit">开户地址</span>
                {{ $_member->bank_address }}
            </div>
            <div class="line">
                <span class="tit">开户行网点</span>
                {{ $_member->bank_branch_name }}
            </div>
            <!-- <div class="line">
              <span class="tit">提款金额</span>
              <input type="text" class="inp" placeholder="输入提款金额(最低100)">
              <span class="tips"><span class="themeCr">*</span>提款金额不能少于100元</span>
            </div> -->
            <div class="line">
                <span class="tit">提款金额</span>
                <input type="text" class="inp" name="money" placeholder="输入提款金额(最低100)">
                <span class="tips error-tips"><i class="iconfont">&#xe743;</i>提款金额不能少于100元</span>
            </div>
            <div class="line">
                <span class="tit">取款密码</span>
                <input type="password" class="inp" name="qk_pwd">
                {{--<i class="iconfont success-icon">&#xe88f;</i>--}}
            </div>
            <div class="line">
                <span class="tit"></span>
                <button type="button" class="ajax-submit-btn account_save">确定</button>
            </div>
        </form>
    </div>
</div>
    @endsection
