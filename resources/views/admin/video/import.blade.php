@extends('layouts.admin')
@section('navbar')
    <a class="navbar-brand"
       href="{{route('admin.video.index')}}">
        {{ config('view.XK_US_AMDIN_NAME') }}
    </a>
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @include('flash::message')
            </div>
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">@if($type==0)头像信息导入@elseif($type==1)在线视频信息导入@elseif($type==2)跳转视频信息导入@endif</div>
                    <div class="panel-body">
                        <form class="form-horizontal" method="POST" action="{{route('admin.video.import',$type)}}" enctype="multipart/form-data">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label for="title" class="col-md-4 control-label">标题</label>
                                <div class="col-md-6">
                                    <input  class="form-control" name="video[title]"
                                            required autofocus>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="s_title" class="col-md-4 control-label">简介</label>
                                <div class="col-md-6">
                                    <input  class="form-control" name="video[content]"
                                            required autofocus>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="s_title" class="col-md-4 control-label">作者</label>
                                <div class="col-md-6">
                                    <input  class="form-control" name="video[author]"
                                            required autofocus>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="s_title" class="col-md-4 control-label">标签</label>
                                <div class="col-md-6">
                                    <input  class="form-control" name="video[tag]"
                                            >
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="s_title" class="col-md-4 control-label">类别</label>
                                <div class="col-md-6">
                                    <input  class="form-control" name="video[sort]"
                                    >
                                </div>
                            </div>

                            @if($type==1)
                                <div class="form-group{{ $errors->has('file') ? ' has-error' : '' }}">
                                    <label for="file" class="col-md-4 control-label">视频选择</label>

                                    <div class="col-md-6">
                                        <input id="file" type="file" class="form-control" name="video"  required autofocus>

                                        @if ($errors->has('file'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('file') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            @if($type==2)
                                <div class="form-group">
                                    <label for="s_title" class="col-md-4 control-label">b站链接</label>
                                    <div class="col-md-6">
                                        <input  class="form-control" name="video[url]" value=""
                                                required autofocus>
                                    </div>
                                </div>
                            @endif

                            <div class="form-group{{ $errors->has('file') ? ' has-error' : '' }}">
                                <label for="file" class="col-md-4 control-label">@if($type==2||$type==1)封面选择@elseif($type==0)头像选择@endif</label>

                                <div class="col-md-6">
                                    <input type="file" class="form-control" name="img"
                                           id="uploadFile" onchange="check()"
                                           required autofocus>

                                    @if ($errors->has('file'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('file') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>





                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        导入
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
