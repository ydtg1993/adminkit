<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>后台</title>

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="shortcut icon" href="{{URL::asset('favicon.ico')}}">
    <link rel="stylesheet" href="{{URL::asset('lib/uikit/css/uikit.min.css')}}">
    <link rel="stylesheet" href="{{URL::asset('css/app.css')}}">
    <link rel="stylesheet" href="{{URL::asset('css/common.css')}}">

    <script src="{{URL::asset('js/jquery.min.js')}}"></script>
    <script src="{{URL::asset('lib/uikit/js/uikit.min.js')}}"></script>
    <script src="{{URL::asset('lib/uikit/js/uikit-icons.js')}}"></script>
    <script src="{{URL::asset('js/jinono.js')}}"></script>
</head>

<body class="hold-transition skin-blue sidebar-mini">
<div uk-sticky="media: 960" class="uk-navbar-container tm-navbar-container uk-sticky uk-sticky-fixed"
     style="position: fixed; top: 0px; width: 100%;background: linear-gradient(to left, #28a5f5, #1e87f0);">
    <div class="uk-container uk-container-expand">
        <nav class="uk-navbar">
            <div class="uk-navbar-left">
                <a href="/" class="uk-navbar-item uk-logo" style="color: #fff;">
                    <svg width="28" height="34" viewBox="0 0 28 34" xmlns="http://www.w3.org/2000/svg"
                         class="uk-margin-small-right uk-svg">
                        <polygon fill="rgb(255, 255, 255)" points="19.1,4.1 13.75,1 8.17,4.45 13.6,7.44 "></polygon>
                        <path fill="rgb(255, 255, 255)"
                              d="M21.67,5.43l-5.53,3.34l6.26,3.63v9.52l-8.44,4.76L5.6,21.93v-7.38L0,11.7v13.51l13.75,8.08L28,25.21V9.07 L21.67,5.43z"></path>
                    </svg>
                    Admin
                </a></div>
            <div class="uk-navbar-right">
                <div class="uk-navbar-item uk-visible@m">
                    <ul class="uk-navbar-nav uk-visible@m">
                        <li><p uk-margin><a class="uk-button uk-button-default" href="#">登出</a></p></li>
                    </ul>
                </div>
        </nav>
    </div>
</div>
<div class="tm-sidebar-left uk-visible@m"><h3><font style="vertical-align: inherit;"><font
                    style="vertical-align: inherit;">菜单</font></font></h3>
    <ul uk-accordion="multiple: true">
        @foreach($navigation as $navs)
        <li class="uk-open">
            <a class="uk-accordion-title" href="#">{{current($navs)['c_name']}}</a>
            <div class="uk-accordion-content">
                <ul class="uk-list">
                    @foreach($navs as $nav)
                        <li><a href="{{url('/'.$nav['slug'])}}">{{$nav['m_name']}}</a></li>
                    @endforeach
                </ul>
            </div>
        </li>
        @endforeach
    </ul>
</div>

</body>
</html>