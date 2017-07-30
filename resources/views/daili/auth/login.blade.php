<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>代理管理系统</title>
    <link rel="stylesheet" href="{{ asset('/node_modules/admin-lte/bootstrap/css/bootstrap.min.css') }}">
    <link href="{{ asset("/admin/lib/font-awesome/4.3.0/css/font-awesome.min.css") }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset("/admin/lib/ionicons/2.0.1/css/ionicons.min.css") }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('/node_modules/admin-lte/dist/css/AdminLTE.min.css') }}">
    <script src="{{ asset('/node_modules/admin-lte/plugins/jQuery/jquery-2.2.3.min.js') }}"></script>
</head>
<body class="login-page">
@include('admin.layouts.topInfo')
<div class="login-box">
    <div class="login-logo">
        <a href="#"><b>代理</b> - 管理系统</a>
    </div><!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">代理管理系统</p>
        <form action="{{ route('daili.login.post') }}" method="post">
            {!! csrf_field() !!}
            <div class="form-group has-feedback">
                <input type="text" class="form-control" name="name" placeholder="账号" required title="请输入账号" value="{{ old('name') }}"/>
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" class="form-control" name="password" placeholder="Password" required title="请输入密码"/>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-8">
                    {{--<div class="checkbox icheck">--}}
                        {{--<label>--}}
                            {{--<input type="checkbox"> Remember Me--}}
                        {{--</label>--}}
                    {{--</div>--}}
                </div>
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">登录</button>
                </div><!-- /.col -->
            </div>
        </form>
        {{--<a href="javascript:void (0)">忘记密码?</a><br>--}}
    </div><!-- /.login-box-body -->
</div><!-- /.login-box -->
</body>
</html>