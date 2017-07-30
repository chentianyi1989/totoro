<div class="header">
    <div class="container-fluid pd_lr_5">
        <div class="f_l"><a href="/"><img src="{{ $_system_config->m_site_logo }}"></a></div>
        <div class="f_r">
            @if (Auth::guard('member')->guest())
            <a class="header_login" href="{{ route('wap.login') }}">登录</a>
            <a class="header_reg" href="{{ route('wap.register') }}">注册</a>
            @else
            <a class="header_login" href="{{ route('wap.userinfo') }}">{{ $_member->name }}</a>
            <a class="header_reg" href="javascript:;" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">退出</a>

                <form id="logout-form" action="{{ route('wap.logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            @endif
        </div>
    </div>
</div>