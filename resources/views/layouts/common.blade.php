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
    <link rel="stylesheet" href="{{URL::asset('css/common.css')}}">

    <script src="{{URL::asset('js/jquery.min.js')}}"></script>
    <script src="{{URL::asset('lib/uikit/js/uikit.min.js')}}"></script>
    <script src="{{URL::asset('lib/uikit/js/uikit-icons.js')}}"></script>
    <script src="{{URL::asset('js/jinono.js')}}"></script>
</head>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <aside class="main-sidebar">

        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

            <!-- Sidebar Menu -->
            <ul class="sidebar-menu" data-widget="tree">
                @foreach($navigation as $navs)
                    @if(sizeof($navs) > 1)
                        <li class="treeview">
                            <a href="#"><i class="fa fa-link"></i> <span>{{current($navs)['c_name']}}</span>
                                <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                @foreach($navs as $nav)
                                <li><a href="{{url('/'.$nav['slug'])}}">{{$nav['m_name']}}</a></li>
                                @endforeach
                            </ul>
                        </li>
                    @else
                        <li @if($slug == current($navs)['slug'])
                                class="active"
                            @endif
                        ><a href="{{url('/'.current($navs)['slug'])}}"><i class="fa fa-link"></i> <span>{{current($navs)['m_name']}}</span></a></li>
                    @endif
                @endforeach
            </ul>
            <!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar -->
    </aside>

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
        </section>

        <!-- Main content -->
        <section class="content container-fluid">
@yield('content')
        </section>
    </div>
</div>
</body>
</html>
