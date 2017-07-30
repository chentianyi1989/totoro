@extends('member.layouts.main')
@section('content')
<div class="userbasic_head">
    <a href="{{ route('member.service_center') }}" class="active" >公告信息</a>
    <a href="{{ route('member.complaint_proposal') }}" >投诉建议</a>
</div>
<div class="userbasic_body">
    <ul class="noticeList">
        @foreach($system_notices as $k => $v)
            <li @if($k == 0)class="active"@endif>
                <h5>{{ $v->title }}</h5>
                <p>✿{{ $v->content }}</p>
            </li>
        @endforeach
    </ul>
</div>
@endsection