@extends('admin.layouts.main')
@section('content')
    <section class="content">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">反馈列表</h3>
            </div>
            <div class="panel-body">
                @include('admin.feedback.filter')

                <table class="table table-bordered table-hover text-center">
                    <tr>
                        <th style="width: 5%">ID</th>
                        <th style="width: 10%">提交人账号</th>
                        <th style="width: 15%">反馈类型</th>
                        <th>反馈内容</th>
                        <th style="width: 10%">已读/未读</th>
                        <th style="width: 10%">提交时间</th>
                        <th style="width: 10%">操作</th>
                    </tr>
                    @foreach($data as $item)
                        <tr>
                            <td>
                                {{ $item->id }}
                            </td>
                            <td>
                                {{ $item->member->name }}
                            </td>
                            <td>
                                {{ config('platform.feedback_type')[$item->type] }}
                            </td>
                            <td>
                                {{ $item->content }}
                            </td>
                            <td>
                                {!! \App\Models\Base::$IS_READ_HTML[$item->is_read] !!}
                            </td>
                            <td>
                                {{ $item->created_at }}
                            </td>
                            <td>
                                @if ($item->is_read == 1)
                                    <a href="{{ route('feedback.check', ['id' => $item->getKey(), 'status' => 0]) }}" class="btn btn-danger btn-xs" onclick="return confirm('确定标记为未读吗？')">未读</a>
                                @elseif($item->is_read == 0)
                                    <a href="{{ route('feedback.check', ['id' => $item->getKey(), 'status' => 1]) }}" class="btn btn-success btn-xs" onclick="return confirm('确定标记为已读吗？')">已读</a>
                                @endif
                                    <button class="btn btn-danger btn-xs"
                                    data-url="{{route('feedback.destroy', ['id' => $item->getKey()])}}"
                                    data-toggle="modal"
                                    data-target="#delete-modal"
                                    >
                                    删除
                                    </button>
                            </td>
                        </tr>
                    @endforeach
                </table>
                <div class="clearfix">
                    <div class="pull-left" style="margin: 0;">
                        <p>总共 <strong style="color: red">{{ $data->total() }}</strong> 条</p>
                    </div>
                    <div class="pull-right" style="margin: 0;">
                        {!! $data->appends(['is_read' => $is_read, 'start_at' => $start_at, 'end_at' => $end_at])->links() !!}
                    </div>
                </div>

            </div>
        </div>

    </section><!-- /.content -->

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">不通过原因</h4>
                </div>
                <div class="modal-body">
                    <form action="" method="post" class="form-horizontal" id="updateReason">
                        {!! csrf_field() !!}
                        <input type="hidden" name="_method" value="put">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="fail_reason" class="col-sm-3 control-label"><span style="color: red">不通过原因</span></label>
                                <div class="col-sm-8">
                                    <textarea name="fail_reason" id="fail_reason" rows="3" required class="form-control"></textarea>
                                </div>
                            </div>
                        </div><!-- /.box-body -->
                        <div class="box-footer">
                            <div class="form-group">
                                <label class="col-sm-3 control-label"></label>
                                <div class="col-sm-8">
                                    <button type="submit" class="btn btn-info btn-flat">提交</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        function showRemark(e)
        {
            var uri = $(e).attr('data-uri');
            $('#updateReason').attr('action',uri)
            $('#myModal').modal('show');
        }
    </script>
@endsection
@section("after.js")
    @include('admin.layouts.delete',['title'=>'操作提示','content'=>'你确定要删除这条反馈吗?'])
    <script>
        var start = {
            elem: '#start_at',
            format: 'YYYY-MM-DD hh:mm:ss',
            //min: laydate.now(), //设定最小日期为当前日期
            max: '2099-06-16 23:59:59', //最大日期
            istime: true,
            istoday: false,
            choose: function(datas){
                end.min = datas; //开始日选好后，重置结束日的最小日期
                end.start = datas //将结束日的初始值设定为开始日
            }
        };
        var end = {
            elem: '#end_at',
            format: 'YYYY-MM-DD 23:59:59',
            //min: laydate.now(),
            max: '2099-06-16 23:59:59',
            istime: true,
            istoday: true,
            choose: function(datas){
                start.max = datas; //结束日选好后，重置开始日的最大日期
            }
        };
        laydate(start);
        laydate(end);
    </script>
@endsection