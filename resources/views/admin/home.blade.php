@extends('layouts.index')

@section('content')

    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main" style="text-align: center;">
        @include('flash::message')
        <div class="col-md-13">
            <div class="panel panel-default">
                <div class="panel-heading">
                    产品管理
                </div>

                <div class="panel-body">
                    <a href="{{route('admin.product.import.index')}}">
                        <button class="btn btn-default">导入产品</button>
                    </a>
                    <a href="{{ route('admin.product.flush.cache') }}">
                        <button class="btn btn-danger">清空缓存</button>
                    </a>
                    <br><br>
                    <p><strong>更新内容后, 记得点击清空缓存</strong></p>
                    <table class="table table-bordered table-hover table-condensed "
                           >
                        <thead>
                        <tr>
                            <th>产品名称</th>
                            <th>产品简介</th>
                            <th>上传时间</th>
                            <th>产品图片</th>
                            <th>操作</th>
                        </tr>
                            @if(count($product) > 0)
                                @foreach($product as $k =>$v)
                        <tr>
                            <td class="col-md-2">
                                {{ $v['title'] }}
                            </td>
                            <td class="col-md-2">
                                {{ $v['content'] }}
                            </td>
                            <td class="col-md-2">
                                {{date('y-m-d H:i:s',$v['upload_time'])}}
                            </td>
                            <td>
                                <img src="{{ config('view.XK_US_ADMIN_TWO') }}{{$v['img_path']}}"
                                     onclick="this.width+=500;this.height+=500; javascript:window.open(this.src);"
                                     style="cursor:pointer; width: 100px; height: 100px;border:1px solid #000000"
                                     name="photopath"/>
                            <td class="col-md-2">
                                <a href="{{route('admin.product.update.index',$v['id'])}}"><button class="btn btn-primary">修改</button></a>
                                <a href="{{route('admin.product.delete',$v['id'])}} " onclick="if(confirm('确定要删除吗？') == false) return false;"><button class="btn btn-danger">删除</button></a>
                            </td>
                        </tr>
                                @endforeach
                            @endif
                        </thead>
                    </table>

                    {{ $product->links() }}

                </div>
            </div>
        </div>
    </div>
@endsection
