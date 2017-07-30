<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header">HEADER</li>
            <!-- Optionally, you can add icons to the links -->
            <li class="active"><a href="{{ route('daili.index') }}"><i class="fa fa-dashboard"></i> <span>控制台</span></a></li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-dashboard"></i> <span>代理管理</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li @if($active_route == 'daili.member_daili') class="active" @endif><a href="{{ route('daili.member_daili') }}"><i class="fa fa-circle-o"></i> 代理列表</a></li>
                    <li @if($active_route == 'daili.member_offline') class="active" @endif><a href="{{ route('daili.member_offline') }}"><i class="fa fa-circle-o"></i> 下线会员</a></li>
                    <li @if($active_route == 'daili.member_offline_recharge') class="active" @endif><a href="{{ route('daili.member_offline_recharge') }}"><i class="fa fa-circle-o"></i> 会员存款记录</a></li>
                    <li @if($active_route == 'daili.member_offline_drawing') class="active" @endif><a href="{{ route('daili.member_offline_drawing') }}"><i class="fa fa-circle-o"></i> 会员提款记录</a></li>
                    <li @if($active_route == 'daili.member_offline_dividend') class="active" @endif><a href="{{ route('daili.member_offline_dividend') }}"><i class="fa fa-circle-o"></i> 会员领取红利记录</a></li>
                    <li @if($active_route == 'daili.member_offline_game_record') class="active" @endif><a href="{{ route('daili.member_offline_game_record') }}"><i class="fa fa-circle-o"></i> 会员输赢报表</a></li>
                    <li @if($active_route == 'daili.daili_money_log') class="active" @endif><a href="{{ route('daili.daili_money_log') }}"><i class="fa fa-circle-o"></i> 佣金记录</a></li>
                </ul>
            </li>
        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
<script>
    $(function(){
        $('.treeview').each(function(e){
            var li_a_num = $(this).find('.active').length
            if (li_a_num > 0)
                $(this).addClass('active')
        })
    })
</script>