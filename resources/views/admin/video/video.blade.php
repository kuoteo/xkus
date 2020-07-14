@extends('layouts.index')

@section('content')

    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main" style="text-align: center;">
        @include('flash::message')
        <div class="col-md-13">
            <div class="panel panel-default">
                <div class="panel-heading">
                    在线视频信息管理
                </div>

                <div class="panel-body">
                    <a href="{{route('admin.video.import.index',1)}}">
                        <button class="btn btn-default">导入在线视频信息</button>
                    </a>
                    <a href="{{ route('admin.video.flush.cache') }}">
                        <button class="btn btn-danger">清空缓存</button>
                    </a>
                    <br><br>
                    <p><strong>更新内容后, 记得点击清空缓存</strong></p>
                    <table class="table table-bordered table-hover table-condensed "
                    >
                        <thead>
                        <tr>
                            <th>标题</th>
                            <th>简介</th>
                            <th>作者</th>
                            <th>上传时间</th>
                            <th>标签</th>
                            <th>类别</th>
                            <th>视频作品</th>
                            <th>作品封面</th>
                            <th>操作</th>
                        </tr>
                        @if(count($videoing) > 0)
                            @foreach($videoing as $k =>$v)
                                <tr>
                                    <td class="col-md-1">
                                        {{ $v['title'] }}
                                    </td>
                                    <td class="col-md-1">
                                        {{ $v['content'] }}
                                    </td>
                                    <td class="col-md-1">
                                        {{ $v['author'] }}
                                    </td>
                                    <td class="col-md-1">
                                        {{date('Y-m-d H:i:s',$v['upload_time'])}}
                                    </td>
                                    <td class="col-md-1">
                                        {{ $v['tag'] }}
                                    </td>
                                    <td class="col-md-1">
                                        {{ $v['sort'] }}
                                    </td>
                                    <td class="">
                                        <img src="{{ config('view.XK_US_ADMIN_TWO') }}{{$v['url']}}"
                                             onclick="this.width+=500;this.height+=500; javascript:window.open(this.src);"
                                             style="cursor:pointer; width: 100px; height: 100px;border:1px solid #000000"
                                             name="photopath"/>
                                    </td>

                                    <td class="">
                                        <img src="{{ config('view.XK_US_ADMIN_TWO') }}{{$v['media_path']}}"
                                             onclick="this.width+=500;this.height+=500; javascript:window.open(this.src);"
                                             style="cursor:pointer; width: 100px; height: 100px;border:1px solid #000000"
                                             name="photopath"/>
                                    </td>
                                    <td class="col-md-2">
                                        <a href="{{route('admin.video.update.index',[$v['type'],$v['id']])}}"><button class="btn btn-primary">修改</button></a>
                                        <a href="{{route('admin.video.delete',$v['id'])}}" onclick="if(confirm('确定要删除吗？') == false) return false;"><button class="btn btn-danger">删除</button></a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </thead>
                    </table>

                    {{ $videoing->links() }}

                </div>
            </div>
        </div>

        <div class="col-md-13">
            <div class="panel panel-default">
                <div class="panel-heading">
                    跳转视频信息管理
                </div>

                <div class="panel-body">

                    <a href="{{route('admin.video.import.index',2)}}">
                        <button class="btn btn-default">导入跳转视频信息</button>
                    </a>
                    <br><br>
                    <table class="table table-bordered table-hover table-condensed "
                    >
                        <thead>
                        <tr>
                            <th>标题</th>
                            <th>简介</th>
                            <th>作者</th>
                            <th>上传时间</th>
                            <th>作品标签</th>
                            <th>类别</th>
                            <th>跳转链接</th>
                            <th>作品封面</th>
                            <th>操作</th>
                        </tr>
                        @if(count($videojump) > 0)
                            @foreach($videojump as $k =>$v)
                                <tr>
                                    <td class="col-md-1">
                                        {{ $v['title'] }}
                                    </td>
                                    <td class="col-md-1">
                                        {{ $v['content'] }}
                                    </td>
                                    <td class="col-md-1">
                                        {{ $v['author'] }}
                                    </td>
                                    <td class="col-md-1">
                                        {{date('Y-m-d H:i:s',$v['upload_time'])}}
                                    </td>
                                    <td class="col-md-1">
                                        {{ $v['tag'] }}
                                    </td>
                                    <td class="col-md-1">
                                        {{ $v['sort'] }}
                                    </td>
                                    <td class="col-md-1">
                                        {{ $v['url'] }}
                                    </td>
                                    <td class="">
                                        <img src="{{ config('view.XK_US_ADMIN_TWO') }}{{$v['media_path']}}"
                                             onclick="this.width+=500;this.height+=500; javascript:window.open(this.src);"
                                             style="cursor:pointer; width: 100px; height: 100px;border:1px solid #000000"
                                             name="photopath"/>
                                    </td>

                                    <td class="col-md-2">
                                        <a href="{{route('admin.video.update.index',[$v['type'],$v['id']])}}"><button class="btn btn-primary">修改</button></a>
                                        <a href="{{route('admin.video.delete',$v['id'])}}" onclick="if(confirm('确定要删除吗？') == false) return false;"><button class="btn btn-danger">删除</button></a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </thead>
                    </table>

                    {{ $videojump->links() }}

                </div>
            </div>
        </div>

        <div class="col-md-13">
            <div class="panel panel-default">
                <div class="panel-heading">
                    头像信息管理
                </div>

                <div class="panel-body">

                    <a href="{{route('admin.video.import.index',0)}}">
                        <button class="btn btn-default">导入头像信息</button>
                    </a>
                    <br><br>
                    <table class="table table-bordered table-hover table-condensed "
                    >
                        <thead>
                        <tr>
                            <th>标题</th>
                            <th>简介</th>
                            <th>作者</th>
                            <th>上传时间</th>
                            <th>标签</th>
                            <th>类别</th>
                            <th>头像</th>
                            <th>操作</th>
                        </tr>
                        @if(count($videoheader) > 0)
                            @foreach($videoheader as $k =>$v)
                                <tr>
                                    <td class="">
                                        {{ $v['title'] }}
                                    </td>
                                    <td class="">
                                        {{ $v['content'] }}
                                    </td>
                                    <td class="">
                                        {{ $v['author'] }}
                                    </td>
                                    <td class="">
                                        {{date('Y-m-d H:i:s',$v['upload_time'])}}
                                    </td>
                                    <td class="">
                                        {{ $v['tag'] }}
                                    </td>
                                    <td class="">
                                    {{ $v['sort']}}
                                    </td>
                                    <td class="">
                                        <img src="{{ config('view.XK_US_ADMIN_TWO') }}{{$v['media_path']}}"
                                             onclick="this.width+=500;this.height+=500; javascript:window.open(this.src);"
                                             style="cursor:pointer; width: 100px; height: 100px;border:1px solid #000000"
                                             name="photopath"/>
                                    </td>
                                    <td class="col-md-2">
                                        <a href="{{route('admin.video.update.index',[$v['type'],$v['id']])}}"><button class="btn btn-primary">修改</button></a>
                                        <a href="{{route('admin.video.delete',$v['id'])}}" onclick="if(confirm('确定要删除吗？') == false) return false;"><button class="btn btn-danger">删除</button></a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </thead>
                    </table>

                    {{ $videoheader->links() }}

                </div>
            </div>
        </div>


    </div>
@endsection
