@extends('layouts.index')

@section('content')

    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main" style="text-align: center;">
        @include('flash::message')
        <div class="col-md-13">
            <div class="panel panel-default">
                <div class="panel-heading">
                    首页轮播海报管理
                </div>

                <div class="panel-body">
                    <a href="{{route('admin.homepage.import.index',0)}}">
                        <button class="btn btn-default">导入首页轮播海报</button>
                    </a>
                    <a href="{{ route('admin.homepage.flush.cache') }}">
                        <button class="btn btn-danger">清空缓存</button>
                    </a>
                    <br><br>
                    <p><strong>更新内容后, 记得点击清空缓存</strong></p>
                    <table class="table table-bordered table-hover table-condensed "
                    >
                        <thead>
                        <tr>
                            <th>标题</th>
                            <th>副标题</th>
                            <th>跳转链接</th>
                            <th>图片</th>
                            <th>操作</th>
                        </tr>
                        @if(count($homebanner) > 0)
                            @foreach($homebanner as $k =>$v)
                                <tr>
                                    <td class="col-md-2">
                                        {{ $v['title'] }}
                                    </td>
                                    <td class="col-md-2">
                                        {{ $v['s_title'] }}
                                    </td>
                                    <td class="col-md-4">
                                        {{ $v['url'] }}
                                    </td>
                                    <td>
                                        <img src="{{ config('view.XK_US_ADMIN_TWO') }}{{$v['img_path']}}"
                                             onclick="this.width+=500;this.height+=500; javascript:window.open(this.src);"
                                             style="cursor:pointer; width: 100px; height: 100px;border:1px solid #000000"
                                             name="photopath"/>
                                    <td class="col-md-2">
                                        <a href="{{route('admin.homepage.update.index',$v['id'])}}"><button class="btn btn-primary">修改</button></a>
                                        <a href=" {{route('admin.homepage.delete',$v['id'])}}" onclick="if(confirm('确定要删除吗？') == false) return false;"><button class="btn btn-danger">删除</button></a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </thead>
                    </table>

                    {{ $homebanner->links() }}

                </div>
            </div>
        </div>

        <div class="col-md-13">
            <div class="panel panel-default">
                <div class="panel-heading">
                    首页简介海报管理
                </div>

                <div class="panel-body">
                    <a href="{{route('admin.homepage.import.index',1)}}">
                        <button class="btn btn-default">导入首页简介海报</button>
                    </a>

                    <br><br>
                    <table class="table table-bordered table-hover table-condensed "
                    >
                        <thead>
                        <tr>
                            <th>标题</th>
                            <th>副标题</th>
                            <th>跳转链接</th>
                            <th>图片</th>
                            <th>操作</th>
                        </tr>
                        @if(count($homecontent) > 0)
                            @foreach($homecontent as $k =>$v)
                                <tr>
                                    <td class="col-md-2">
                                        {{ $v['title'] }}
                                    </td>
                                    <td class="col-md-2">
                                        {{ $v['s_title'] }}
                                    </td>
                                    <td class="col-md-4">
                                        {{ $v['url'] }}
                                    </td>
                                    <td>
                                        <img src="{{ config('view.XK_US_ADMIN_TWO') }}{{$v['img_path']}}"
                                             onclick="this.width+=500;this.height+=500; javascript:window.open(this.src);"
                                             style="cursor:pointer; width: 100px; height: 100px;border:1px solid #000000"
                                             name="photopath"/>
                                    <td class="col-md-2">
                                        <a href="{{route('admin.homepage.update.index',$v['id'])}}"><button class="btn btn-primary">修改</button></a>
                                        <a href=" {{route('admin.homepage.delete',$v['id'])}}" onclick="if(confirm('确定要删除吗？') == false) return false;"><button class="btn btn-danger">删除</button></a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </thead>
                    </table>

                    {{ $homecontent->links() }}

                </div>
            </div>
        </div>

    </div>
@endsection
