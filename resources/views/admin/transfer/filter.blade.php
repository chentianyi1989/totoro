<div class="container-fluid" style="margin-bottom: 10px;">
    <form action="" method="get" id="searchForm">
        <div class="row">
            <div class="col-lg-3">
                <div class="input-group">
                    <span class="input-group-addon">用户</span>
                    <input type="text" name="name" class="form-control" value="{{ $name }}">
                </div>
            </div>
            <div class="col-lg-2">
                <div class="input-group">
                    <span class="input-group-addon">转出/转入</span>
                    <select name="transfer_type" id="transfer_type" class="form-control">
                        <option value="">--请选择--</option>
                        @foreach(config('platform.transfer_type') as $k => $v)
                            <option value="{{ $k }}" @if(is_numeric($transfer_type) && $transfer_type == $k) selected @endif>{{ $v }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="input-group">
                    <span class="input-group-addon">转入账户</span>
                    <select name="transfer_in_account" id="transfer_in_account" class="form-control">
                        <option value="">--请选择--</option>
                        <option value="中心账户">中心账户</option>
                        @foreach($_api_list as $k => $v)
                            <option value="{{ $v }}" @if($transfer_in_account == $v) selected @endif>{{ $v }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="input-group">
                    <span class="input-group-addon">转出账户</span>
                    <select name="transfer_out_account" id="transfer_out_account" class="form-control">
                        <option value="">--请选择--</option>
                        <option value="中心账户">中心账户</option>
                        <option value="返水账户">返水账户</option>
                        @foreach($_api_list as $k => $v)
                            <option value="{{ $v }}" @if($transfer_out_account == $v) selected @endif>{{ $v }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="row" style="margin-top: 5px;">
            <div class="col-lg-3">
                <div class="input-group">
                    <span class="input-group-addon">开始时间</span>
                    <input type="text" class="form-control" name="start_at" id="start_at" value="{{ $start_at }}" readonly>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="input-group">
                    <span class="input-group-addon">结束时间</span>
                    <input type="text" class="form-control" name="end_at" id="end_at" value="{{ $end_at }}" readonly>
                </div>
            </div>
            <div class="col-lg-2 pull-right">
                <div class="input-group">
                    <button type="submit" class="btn btn-primary">搜索</button>&nbsp;
                    <button type="button" class="btn btn-warning" id="restSearchForm">重置</button>&nbsp;
                </div>
            </div>
        </div>
    </form>
</div>