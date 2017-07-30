@extends('admin.layouts.main')
@section('content')
    <section class="content">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">编辑银行卡</h3>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" id="form" action="{{ route('bank_card.update', ['id' => $data->id]) }}" method="post">
                    <input type="hidden" name="_method" value="put">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="level" class="col-sm-2 control-label">选择开户行 <strong style="color: red">*</strong></label>
                            <div class="col-sm-7">
                                <select name="bank_id" id="bank_id" class="form-control">
                                    <option value="">--请选择--</option>
                                    @foreach(\App\Models\Base::$BANK_TYPE as $k => $v)
                                        <option value="{{ $k }}" @if($k == $data->id) selected @endif>{{ $v }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="username" class="col-sm-2 control-label">持卡人姓名 <strong style="color: red">*</strong></label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="username" name="username" value="{{ $data->username }}" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="card_no" class="col-sm-2 control-label">卡号 <strong style="color: red">*</strong></label>
                            <div class="col-sm-7">
                                <input type="number" class="form-control" id="card_no" name="card_no" value="{{ $data->card_no }}" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="bank_address" class="col-sm-2 control-label">开户地</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="bank_address" name="bank_address" value="{{ $data->bank_address }}" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="phone" class="col-sm-2 control-label">预留手机号</label>
                            <div class="col-sm-7">
                                <input type="number" class="form-control" id="phone" name="phone" value="{{ $data->phone }}" />
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                    <div class="box-footer">
                        <div class="form-group">
                            <label class="col-sm-2 control-label"></label>
                            <div class="col-sm-7">
                                <button type="button" class="btn btn-primary submit-form-sync">提交</button>
                                &nbsp;<a href="{{ route('bank_card.index') }}" class="btn btn-info">返回</a>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>

    </section><!-- /.content -->
@endsection