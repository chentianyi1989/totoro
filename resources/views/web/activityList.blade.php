@extends('web.layouts.main')
@section('content')
<div class="pro-b-bg"></div>
<div class="pro-b-banner container">
    <img src="{{ asset('/web/images/pro-banner.jpg') }}" alt="">
</div>

<div class="container">
    <ul class="pro-ul">
        @foreach($data as $item)
            <li>
                <div>
                    <a href="javascript:;">
                        <img src="{{ asset('/web/images/pro-banner-10b.jpg') }}" alt="">
                    </a>
                </div>
                <h2 class="ov-h">{{ $item->title }}</h2>
                <p>{{ $item->subtitle }}</p>
                <span>
                    活动时间：{{ $item->date_desc }}
                    <a href="{{ route('web.activityDetail', ['id' => $item->id]) }}">
                      活动详情
                      <em>></em>
                    </a>
                </span>
            </li>
        @endforeach
        {{--<li>--}}
            {{--<div>--}}
                {{--<a href="javascript:;">--}}
                    {{--<img src="{{ asset('/web/images/pro-banner-10b.jpg') }}" alt="">--}}
                {{--</a>--}}
            {{--</div>--}}
            {{--<h2 class="ov-h">信息认证红利 完成个人信息验证就能轻轻松松领礼金！</h2>--}}
            {{--<p>信息认证红利是会员完成通过相关的条件后，系统给予的现金奖励。用户可到“个人中心”的“自助优惠”页面进行申领操作</p>--}}
            {{--<span>--}}
        {{--活动时间：长期有效--}}
        {{--<a href="javascript:;">--}}
          {{--活动详情--}}
          {{--<em>></em>--}}
        {{--</a>--}}
      {{--</span>--}}
        {{--</li>--}}
        {{--<li>--}}
            {{--<div>--}}
                {{--<a href="javascript:;">--}}
                    {{--<img src="{{ asset('/web/images/pro-banner-10b.jpg') }}" alt="">--}}
                {{--</a>--}}
            {{--</div>--}}
            {{--<h2 class="ov-h">信息认证红利 完成个人信息验证就能轻轻松松领礼金！</h2>--}}
            {{--<p>信息认证红利是会员完成通过相关的条件后，系统给予的现金奖励。用户可到“个人中心”的“自助优惠”页面进行申领操作</p>--}}
            {{--<span>--}}
        {{--活动时间：长期有效--}}
        {{--<a href="javascript:;">--}}
          {{--活动详情--}}
          {{--<em>></em>--}}
        {{--</a>--}}
      {{--</span>--}}
        {{--</li>--}}
    </ul>
</div>

<div class="body">

</div>
@endsection