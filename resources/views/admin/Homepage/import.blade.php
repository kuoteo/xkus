@extends('layouts.admin')
@section('navbar')
    <a class="navbar-brand"
       href="{{route('admin.homepage.index')}}">
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
                    <div class="panel-heading">{{ $model }}</div>
                    <div class="panel-body">
                        <form class="form-horizontal" method="POST" action="{{ route('admin.homepage.import',$type)}}" enctype="multipart/form-data">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label for="title" class="col-md-4 control-label">标题</label>
                                <div class="col-md-6">
                                    <input  class="form-control" name="homepage[title]"
                                            required autofocus>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="s_title" class="col-md-4 control-label">副标题</label>
                                <div class="col-md-6">
                                    <input  class="form-control" name="homepage[s_title]"
                                            required autofocus>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="url" class="col-md-4 control-label">跳转链接</label>
                                <div class="col-md-6">
                                    <input  class="form-control" name="homepage[url]"
                                            >
                                </div>
                            </div>


                            <div class="form-group{{ $errors->has('file') ? ' has-error' : '' }}">
                                <label for="file" class="col-md-4 control-label">图片选择</label>

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
