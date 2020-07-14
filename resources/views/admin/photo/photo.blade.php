@extends('layouts.index')

@section('content')

    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main" style="text-align: center;">
        @include('flash::message')
        <div class="col-md-13">
            <div class="panel panel-default">
                <div class="panel-heading">
                    摄影海报信息管理
                </div>

                <div class="panel-body">
                    <a href="{{route('admin.photo.import.index',0)}}">
                        <button class="btn btn-default">导入摄影海报信息</button>
                    </a>
                    <a href="{{ route('admin.photo.flush.cache') }}">
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
                            <th>摄影师</th>
                            <th>上传时间</th>
                            <th>摄影标签</th>
                            <th>摄影作品</th>
                            <th>操作</th>
                        </tr>
                        @if(count($photobanner) > 0)
                            @foreach($photobanner as $k =>$v)
                                <tr>
                                    <td class="col-md-2">
                                        {{ $v['title'] }}
                                    </td>
                                    <td class="col-md-2">
                                        {{ $v['content'] }}
                                    </td>
                                    <td class="col-md-2">
                                        {{ $v['author'] }}
                                    </td>
                                    <td class="col-md-2">
                                        {{date('Y-m-d H:i:s',$v['upload_time'])}}
                                    </td>
                                    <td class="col-md-2">
                                        {{ $v['tag'] }}
                                    </td>
                                    <td>
                                        <img src="{{ config('view.XK_US_ADMIN_TWO') }}{{$v['media_path']}}"
                                             onclick="this.width+=500;this.height+=500; javascript:window.open(this.src);"
                                             style="cursor:pointer; width: 100px; height: 100px;border:1px solid #000000"
                                             name="photopath"/>
                                    <td class="col-md-2">
                                        <a href="{{route('admin.photo.update.index', [$v['type'],$v['id']])}}"><button class="btn btn-primary">修改</button></a>
                                        <a href="{{route('admin.photo.delete', $v['id'])}}" onclick="if(confirm('确定要删除吗？') == false) return false;"><button class="btn btn-danger">删除</button></a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </thead>
                    </table>
                    {{ $photobanner->links() }}
                </div>
            </div>
        </div>
        <div class="col-md-13">
            <div class="panel panel-default">
                <div class="panel-heading">
                    摄影信息管理
                </div>

                <div class="panel-body">
                    <a href="{{route('admin.photo.import.index',1)}}">
                        <button class="btn btn-default">导入摄影信息</button>
                    </a>

                    <br><br>
                    <table class="table table-bordered table-hover table-condensed "
                    >
                        <thead>
                        <tr>
                            <th>标题</th>
                            <th>简介</th>
                            <th>摄影师</th>
                            <th>上传时间</th>
                            <th>摄影标签</th>
                            <th>摄影作品</th>
                            <th>操作</th>
                        </tr>
                        @if(count($photo) > 0)
                            @foreach($photo as $k =>$v)
                                <tr>
                                    <td class="col-md-2">
                                        {{ $v['title'] }}
                                    </td>
                                    <td class="col-md-2">
                                        {{ $v['content'] }}
                                    </td>
                                    <td class="col-md-2">
                                        {{ $v['author'] }}
                                    </td>
                                    <td class="col-md-2">
                                        {{date('Y-m-d H:i:s',$v['upload_time'])}}
                                    </td>
                                    <td class="col-md-2">
                                        {{ $v['tag'] }}
                                    </td>
                                    <td>
                                        <img src="{{ config('view.XK_US_ADMIN_TWO') }}{{$v['media_path']}}"
                                             onclick="this.width+=500;this.height+=500; javascript:window.open(this.src);"
                                             style="cursor:pointer; width: 100px; height: 100px;border:1px solid #000000"
                                             name="photopath"/>
                                    <td class="col-md-2">
                                        <a href="{{route('admin.photo.update.index', [$v['type'],$v['id']])}}"><button class="btn btn-primary">修改</button></a>
                                        <a href="{{route('admin.photo.delete', $v['id'])}}" onclick="if(confirm('确定要删除吗？') == false) return false;"><button class="btn btn-danger">删除</button></a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </thead>
                    </table>

                    {{ $photo->links() }}
                </div>
            </div>
        </div>
        <div class="col-md-13">
            <div class="panel panel-default">
                <div class="panel-heading">
                    摄影师信息管理
                </div>

                <div class="panel-body">
                    <a href="{{route('admin.photo.import.index',2)}}">
                        <button class="btn btn-default">导入摄影师信息</button>
                    </a>

                    <br><br>
                    <table class="table table-bordered table-hover table-condensed "
                    >
                        <thead>
                        <tr>
                            <th>摄影师</th>
                            <th>艺名</th>
                            <th>简介</th>
                            <th>上传时间</th>
                            <th>摄影师标签</th>
                            <th>头像</th>
                            <th>操作</th>
                        </tr>
                        @if(count($photoer) > 0)
                            @foreach($photoer as $k =>$v)
                                <tr>
                                    <td class="col-md-2">
                                        {{ $v['author'] }}
                                    </td>
                                    <td class="col-md-2">
                                        {{ $v['title'] }}
                                    </td>
                                    <td class="col-md-2">
                                        {{ $v['content'] }}
                                    </td>
                                    <td class="col-md-2">
                                        {{date('Y-m-d H:i:s',$v['upload_time'])}}
                                    </td>
                                    <td class="col-md-2">
                                        {{ $v['tag'] }}
                                    </td>
                                    <td>
                                        <img src="{{ config('view.XK_US_ADMIN_TWO') }}{{$v['media_path']}}"
                                             onclick="this.width+=500;this.height+=500; javascript:window.open(this.src);"
                                             style="cursor:pointer; width: 100px; height: 100px;border:1px solid #000000"
                                             name="photopath"/>
                                    <td class="col-md-2">
                                        <a href="{{route('admin.photo.update.index', [$v['type'],$v['id']])}}"><button class="btn btn-primary">修改</button></a>
                                        <a href="{{route('admin.photo.delete', $v['id'])}}" onclick="if(confirm('确定要删除吗？') == false) return false;"><button class="btn btn-danger">删除</button></a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </thead>
                    </table>

                    {{ $photoer->links() }}
                </div>
            </div>
        </div>



    </div>
@endsection
