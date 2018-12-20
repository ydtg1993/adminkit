<!DOCTYPE html>
<html lang="zh-cmn-Hans">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('meta')

    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/adminlte.min.css')}}">
    @yield('css')
    <script src="{{asset('js/jquery-3.3.1.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <script src="{{asset('js/js.cookie.js')}}"></script>
    <script src="{{asset('js/admin.js')}}" ></script>
</head>
<body class="@yield('body-class') hold-transition skin-blue sidebar-mini">

@yield('header')
@yield('left')
@yield('body')
@yield('js-lib')
@yield('js')
</body>
</html>

