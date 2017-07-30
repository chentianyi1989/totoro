@extends('web.layouts.main')
@section('content')
    <div class="body">
        <div class="by-bg">
            <div class="container by-nr">
                <div class="pullLeft ag-by-bg">
                    <a class="pullLeft" href="javascript:;" @if($_member) onclick="javascript:window.open('{{ route('ag.playGame') }}?id=6','','width=1024,height=768')" @else onclick="return alert('请先登录！')"  @endif></a>
                </div>
                <div class="pullLeft pt-by-bg">
                    <img class="isComing" src="{{ asset('/web/images/isComing.png') }}" alt="">
                    <a class="pullLeft disabled" href="javascript:;"></a>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(function(){
            $('.disabled').on('click',function(){
                layer.msg('暂未开放，敬请期待',{icon:6});
            });
        })
    </script>

@endsection