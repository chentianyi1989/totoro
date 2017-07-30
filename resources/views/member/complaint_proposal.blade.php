@extends('member.layouts.main')
@section('content')
<div class="userbasic_head">
    <a href="{{ route('member.service_center') }}">公告信息</a>
    <a href="{{ route('member.complaint_proposal') }}" class="active" >投诉建议</a>
</div>
<div class="userbasic_body">
    <div class="bank_tips">温馨提示：您的参与将帮助我们改进产品及服务</div>
    <div class="line_form complaint_form">
        <form action="{{ route('member.post_feedback') }}" method="post">
        <div class="line">
            <span class="tit">反馈类型</span>
            <select class="select" name="type">
                <option value="">--请选择--</option>
                @foreach(config('platform.feedback_type') as $k => $v)
                    <option value="{{ $k }}">{{ $v }}</option>
                    @endforeach
            </select>
        </div>
        <div class="line">
            <span class="tit">意见反馈</span>
            <textarea name="content"></textarea>
        </div>
        <div class="line">
            <span class="tit">联系电话</span>
            <input type="text" class="inp" placeholder="联系电话" name="phone">
        </div>
        <div class="line">
            <span class="tit"></span>
            <button type="button" class="ajax-submit-btn account_save">提交</button>

        </div>
        </form>
    </div>
</div>
    @endsection