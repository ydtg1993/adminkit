@extends('app')
@section('title')@yield('subtitle') | 玩转互娱@stop

@section('css')
    <link rel="stylesheet" href="{{asset('css/_all-skins.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}">
    @parent
@stop
@section('body')
    @if(!empty($user_info))
        <div class="wrapper">
            @include('layouts.header')
            @include('layouts.left')
            <div class="content-wrapper">
                @yield('container')
            </div>
            <footer class="main-footer"></footer>
        </div>
        @else
        @yield('container')
    @endif
@stop

@section('js-lib')
    @parent
    <script src="{{asset('js/adminlte.min.js')}}"></script>
@stop

@section('js')

@stop