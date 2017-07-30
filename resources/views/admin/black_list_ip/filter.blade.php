<div class="container-fluid" style="margin-bottom: 10px;">
    <form action="" method="get" id="searchForm">
        <div class="row">
            <div class="col-lg-2">
                <div class="input-group">
                    <span class="input-group-addon">IP</span>
                    <input type="text" class="form-control" name="ip" value="{{ $ip }}">
                </div>
            </div>
        </div>
        <div class="row" style="margin-top: 5px;">
            <div class="col-lg-3 pull-right">
                <div class="input-group">
                    <button type="submit" class="btn btn-primary">搜索</button>&nbsp;
                    <button type="button" class="btn btn-warning" id="restSearchForm">重置</button>&nbsp;
                    <a href="{{ route('black_list_ip.create') }}" class="btn btn-info"><span class="glyphicon glyphicon-plus"></span>添加ip黑名单</a>
                </div>
            </div>
        </div>
    </form>
</div>