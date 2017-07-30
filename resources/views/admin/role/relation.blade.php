@extends('admin.layouts.main')
@section('content')
    <section class="content">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">关联权限--{{ $data->name }}</h3>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" id="form" action="{{ route('role.relation', ['id' => $data->id]) }}" method="post">
                    <table class="table table-striped">
                        <?php
                            $check_routers = $data->routers()->pluck('router')->toArray();
                        ?>
                        @foreach(config('admin_menu') as $item)
                            <tr class="row">
                                <td class="col-md-1 pull-left">
                                    <strong style="color: red">{{ $item['name'] }}</strong>
                                </td>
                            </tr>

                            <tr class="row">
                                <td class="col-md-1 pull-left">菜单权限：</td>
                                @foreach($item['submenus'] as $v)
                                    <td class="col-md-1 pull-left">
                                        <label>
                                            <input type="checkbox" name="routers[]" value="{{ $v['router'] }}" @if(in_array($v['router'], $check_routers)) checked @endif @if($v['is_hide'] == 0) disabled @endif>{{ $v['title'] }}
                                        </label>
                                    </td>
                                @endforeach
                            </tr>
                            <tr class="row">
                                <td class="col-md-1 pull-left">操作权限：</td>
                                @foreach($item['submenus'] as $v)
                                    @foreach($v['actions'] as $val)
                                        <td class="col-md-1 pull-left">
                                            <label>
                                                <input type="checkbox" name="routers[]" value="{{ $val['router'] }}" @if(in_array($val['router'], $check_routers)) checked @endif>{{ $val['name'] }}
                                            </label>
                                        </td>
                                    @endforeach
                                @endforeach
                            </tr>
                        @endforeach
                        <tfoot>
                            <tr>
                                <td colspan="12">
                                    <button type="button" class="btn btn-primary submit-form-sync">提交</button>
                                    &nbsp;<a href="{{ route('role.index') }}" class="btn btn-info">返回</a>
                                </td>
                            </tr>
                        </tfoot>
                    </table>

                </form>

            </div>
        </div>

    </section><!-- /.content -->
@endsection