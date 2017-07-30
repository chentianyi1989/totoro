@extends('admin.layouts.main')
@section('content')
    <section class="content">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">添加接口</h3>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" id="form" action="{{ route('api.store') }}" method="post">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="api_name" class="col-sm-2 control-label">接口名称 <strong style="color: red">*</strong></label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="api_name" name="api_name" placeholder="例：AG" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="api_domain" class="col-sm-2 control-label">接口基础域名</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="api_domain" name="api_domain" placeholder="例：api.888.com" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="prefix" class="col-sm-2 control-label">账号前缀</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="prefix" name="prefix" placeholder="例：9k" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="api_Id" class="col-sm-2 control-label">API ID</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="api_Id" name="api_Id" placeholder="例：MTmotong9k" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="api_Key" class="col-sm-2 control-label">API KEY</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="api_Key" name="api_Key" placeholder="例：hxx7RDp3TKHkaekjrSZYkRVGFytYeXYCZ" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="api_token" class="col-sm-2 control-label">API TOKEN</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="api_token" name="api_token" placeholder="" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="api_username" class="col-sm-2 control-label">API USERNAME</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="api_username" name="api_username" placeholder="" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="api_password" class="col-sm-2 control-label">API PASSWORD</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="api_password" name="api_password" placeholder="" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="api_money" class="col-sm-2 control-label">API MONEY</label>
                            <div class="col-sm-7">
                                <input type="number" class="form-control" id="api_money" name="api_money" placeholder="" value="0" min="0" />
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                    <div class="box-footer">
                        <div class="form-group">
                            <label class="col-sm-2 control-label"></label>
                            <div class="col-sm-7">
                                <button type="button" class="btn btn-primary submit-form-sync">提交</button>
                                &nbsp;<a href="{{ route('api.index') }}" class="btn btn-info">返回</a>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>

    </section><!-- /.content -->
@endsection