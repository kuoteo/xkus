@extends('layouts.admin')
@section('navbar')
    <a class="navbar-brand"
       href="{{route('admin.product')}}">
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
                    <div class="panel-heading">产品修改</div>
                    <div class="panel-body">
                        <form class="form-horizontal" method="POST" action="" enctype="multipart/form-data">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label for="title" class="col-md-4 control-label">产品名称</label>
                                <div class="col-md-6">
                                    <input  class="form-control" name="product[title]"
                                            value="{{ old('product')['title'] ? old('product')['title'] : $product->title }}"
                                            required autofocus>
                                </div>
                            </div>



                            <div class="form-group">
                                <label for="content" class="col-md-4 control-label">产品简介</label>
                                <div class="col-md-6">
                                    <textarea class="form-control" rows="3" cols="10" maxlength="50" name="product[content]"
                                              required autofocus>{{ old('product')['content'] ? old('product')['content'] : $product->content }}</textarea>
                                </div>
                            </div>


                            <div class="form-group{{ $errors->has('file') ? ' has-error' : '' }}">
                                <label for="file" class="col-md-4 control-label">图片选择</label>

                                <div class="col-md-6">
                                    <input type="file" class="form-control" name="img"
                                           id="uploadFile" onchange="check()"
                                           value="{{ old('product')['img_path'] ? old('product')['img_path'] : $product->img_path}}"
                                           >

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
