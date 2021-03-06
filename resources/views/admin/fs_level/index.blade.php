@extends('admin.layouts.main')
@section('content')
     <section class="content">
         <div class="panel panel-primary">
             <div class="panel-heading">
                 <h3 class="panel-title">返水等级列表</h3>
             </div>
             <div class="panel-body">
                 @include('admin.fs_level.filter')
                 <h3 style="color: red" class="text-center"> 发放返水时会按照返水等级倒序匹配</h3>
                 <table class="table table-bordered table-hover text-center">
                     <tr>
                         <th style="width: 10%">ID</th>
                         <th class="text-center">返水等级</th>
                         <th  style="width: 30%">等级名称</th>
                         <th  style="width: 20%">额度</th>
                         <th  style="width: 10%">返水比例</th>
                         <th  style="width: 20%">操作</th>
                     </tr>
                     @foreach($data as $item)
                         <tr>
                             <td>
                                 {{ $item->id }}
                             </td>
                             <td>
                                 {{ $item->level }}
                             </td>
                             <td>
                                 {{ $item->name }}
                             </td>
                             <td>
                                 {{ $item->quota }}
                             </td>
                             <td>
                                 {{ $item->rate }}%
                             </td>
                             <td>
                                 <a href="{{ route('fs_level.edit', ['id' => $item->getKey()]) }}" class="btn btn-primary btn-xs">修改</a>
                                 <button class="btn btn-danger btn-xs"
                                         data-url="{{route('fs_level.destroy', ['id' => $item->getKey()])}}"
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
                     {!! $data->render() !!}
                 </div>
                 </div>
             </div>
         </div>

     </section><!-- /.content -->
@endsection
@section("after.js")
     @include('admin.layouts.delete',['title'=>'操作提示','content'=>'你确定要删除这个返水等级吗?'])
@endsection