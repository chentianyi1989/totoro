<!--登录模态框-->
<div id="login" class="modal modal-login">
    <div class="modal-content">
        <form method="POST" action="{{ route('member.login.post') }}">
            <a href="" class="close bg-icon"></a>
            <div class="modal-login_form">
                <h2>用户登录</h2>
                <div class="modal-login_line">
                    <input class="username" type="text" placeholder="请输入用户名" required name="name">
                </div>
                <div class="modal-login_line">
                    <input class="psw" type="password" placeholder="请输入密码" required name="password">
                </div>
                <!-- <div class="modal-login_line code">
                    <input type="text" placeholder="请输入验证码" required name="code">
                    <img src="" alt="" width="100">
                </div> -->
                <div class="modal-login_line">
                    <button class="modal-login_submit ajax-submit-btn" type="button">登录</button>
                </div>
                <div class="modal-login_link clear">
                    <p class="pullRight">
                        还没有账号？
                        <a href="{{ route('web.register_one') }}">点击注册</a>
                    </p>
                </div>
            </div>
        </form>
    </div>
</div>


@if (session('msg_ok')|| session('msg_no') || $errors->any())
    <script>
        var content = "{{ session('msg_no') }}";
        $(function () {
//        $('#msg_tips').modal({
//        });
            layer.msg(content, {icon:6})
        })
    </script>
@endif

<!--半透明遮罩层-->
<div class="backdrop"></div>


<div class="header">
    <div class="container">
        <div class="header_hd clear">
            <div class="pullLeft">
                <a href="javascript:;" style="color: #0BFD00"></a>
                {{--<a href="" style="color: #0BFD00">MG电子</a>&nbsp;|--}}
                {{--<a href="" style="color: #E91818">在线申请活动</a>&nbsp;|--}}
                {{--<a href="" style="color: #F7EB2B">资讯端下载</a>&nbsp;|--}}
                {{--<a href="" style="color: #CC9494">问卷调查</a>&nbsp;|--}}
                {{--<a href="" style="color: #22C6F0">AG免费试玩</a>--}}
            </div>
            <div class="pullRight">
                {{--<a href="javascript:;">设为首页</a>&nbsp;|--}}
                {{--<a href="javascript:;" style="color: #F81E6B">下载专区</a>&nbsp;|--}}
                {{--<a href="javascript:;" style="color: #DC9A1D">路线检测</a>--}}
            </div>
        </div>
        <div class="header_bd clear">
            <a href="" class="pullLeft header-logo">
                <img src="" alt="">
            </a>
            <div class="login-warp pullRight">
                @if (Auth::guard('member')->guest())
                <form method="POST" action="{{ route('member.login.post') }}" class="clear">
                    {{--<div class="pullLeft">--}}
                        {{--<a href="{{ route('web.register_one') }}" class="header-join"></a>--}}
                    {{--</div>--}}
                    <div class="pullLeft login-area">
                        <div class="login-unit login-unit-user">
                            <input type="text" placeholder="用户名" name="name">
                        </div>
                        <div class="login-unit login-unit-psw">
                            <input type="password" placeholder="密码" name="password">
                        </div>
                        {{--<div class="login-unit login-unit-chk">--}}
                            {{--<input type="text" placeholder="验证码">--}}
                            {{--<img class="vPic" src="{{ asset('/web/images/xierdun/macpic.png') }}" alt="">--}}
                        {{--</div>--}}
                        <a href="javascript:;" onclick="return alert('请联系客服')" class="forget-pw">忘记密码</a>
                        <input type="button" value="" class="login-submit ajax-submit-btn">
                    </div>
                </form>
                @else
                <div class="isLogin clear">
                    <div class="mem-info">
                        账号：{{ $_member->name }}&nbsp;&nbsp;&nbsp;余额：{{ $_member->money }}元&nbsp;&nbsp;&nbsp;
                        <a href="javascript:;" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">登出</a>
                        <form id="logout-form" action="{{ route('member.logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </div>
                    <div class="SU-Menual-box">
                        <div class="SU-Menual">
                            <ul>
                                <li><a href="{{ route('member.userCenter') }}">会员中心</a></li>
                                <li><a href="{{ route('member.finance_center') }}">线上存款</a></li>
                                <li><a href="{{ route('member.member_drawing') }}">线上取款</a></li>
                                <li><a href="{{ route('member.indoor_transfer') }}">额度转换</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                    @endif
            </div>
        </div>
        <div class="header_ft">
            <div class="mainnav">
                <ul class="clear">
                    <li @if($web_route == 'web.index') class="active" @endif>
                        <a href="{{ route('web.index') }}">
                            首页
                            <span>Home</span>
                        </a>
                    </li>
                    <li @if($web_route == 'web.egame') class="active" @endif>
                        <a href="{{ route('web.egame') }}">
                            电子游艺
                            <span>CASINO</span>
                        </a>
                    </li>
                    <li @if($web_route == 'web.catchFish') class="active" @endif>
                        <a href="{{ route('web.catchFish') }}">
                            捕鱼游戏
                            <span>CASINO</span>
                        </a>
                    </li>
                    <li @if($web_route == 'web.liveCasino') class="active" @endif>
                        <a href="{{ route('web.liveCasino') }}">
                            视讯直播
                            <span>LIVE CASINO</span>
                        </a>
                    </li>
                    <li @if($web_route == 'web.esports') class="active" @endif>
                        <a href="{{ route('web.esports') }}">
                            体育赛事
                            <span>SPORTS</span>
                        </a>
                    </li>
                    <li @if($web_route == 'web.lottory') class="active" @endif>
                        <a href="{{ route('web.lottory') }}">
                            彩票游戏
                            <span>LOTTERY</span>
                        </a>
                    </li>
                    {{--<li>--}}
                        {{--<a href="javascript:;">--}}
                            {{--优惠活动--}}
                            {{--<span>PROMOTIONS</span>--}}
                        {{--</a>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                        {{--<a href="javascript:;">--}}
                            {{--手机投注--}}
                            {{--<span>MOBILE BET</span>--}}
                        {{--</a>--}}
                    {{--</li>--}}
                    <li>
                        <a href="http://api1.pop800.com/chat/291222" target="_blank">
                            在线客服
                            <span>ONLINE SERVICE</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>