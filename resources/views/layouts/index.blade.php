<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('view.XK_US_AMDIN_NAME') }}</title>

    <!-- Styles -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

</head>
<body>
<div id="app">
    <nav class="navbar navbar-default navbar-static-top ">
        <div class="container">
            <div class="navbar-header navbar-left">
                <!-- Branding Image -->
                <a class="navbar-brand"
                   href="{{route('admin.product')}}">
                    {{ config('view.XK_US_AMDIN_NAME') }}
                </a>
                <a class="navbar-brand navbar-right"
                   href="{{ route('admin.logout') }}">
                    {{ config('view.XK_US_AMDIN_EDIT') }}
                </a>
            </div>

        </div>
    </nav>


    <div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
        <form role="search">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Search">
            </div>
        </form>
        <ul class="nav menu">
            <li><a href="{{route('admin.product')}}"><span class="glyphicon glyphicon-dashboard"></span>产品</a></li>
            <li><a href="{{route('admin.photo.index')}}"><span class="glyphicon glyphicon-th"></span>摄影</a></li>
            <li><a href="{{route('admin.video.index')}}"><span class="glyphicon glyphicon-stats"></span>视频</a></li>
            <li><a href="{{route('admin.vision.index')}}"><span class="glyphicon glyphicon-eye-open"></span>视觉</a></li>
            <li><a href="{{route('admin.homepage.index')}}"><span class="glyphicon glyphicon-pencil"></span>首页</a></li>
            <li role="presentation" class="divider"></li>
        </ul>
    </div>
    @yield('content')
</div>

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
