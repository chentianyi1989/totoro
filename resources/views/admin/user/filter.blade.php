<div class="box-header">
    <form action="" method="get" id="searchForm">
        <div class="row">
            <div class="col-lg-3">
                <div class="input-group">
                    <span class="input-group-addon">姓名</span>
                    <input type="text" class="form-control" name="name" placeholder="关键字" value="{{ $name }}">
                </div>
            </div>
            <div class="col-lg-3">
                <div class="input-group">
                    <span class="input-group-addon">管理组</span>
                    <select name="role_id" id="role_id" class="form-control">
                        <option value="">--请选择--</option>
                        @foreach($role_list as $k => $v)
                            <option value="{{ $k }}" @if($k == $role_id) selected @endif>{{ $v }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="input-group">
                    <button type="submit" class="btn btn-primary">搜索</button>&nbsp;
                    <button type="button" class="btn btn-warning" id="restSearchForm">重置</button>&nbsp;
                    <a href="{{ route('user.create') }}" class="btn btn-danger"><span class="glyphicon glyphicon-plus"></span>添加管理员</a>
                </div>
            </div>
        </div>
    </form>
</div>