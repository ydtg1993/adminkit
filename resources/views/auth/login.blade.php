@extends('layouts.master')
@section('title','登陆 | 玩转互娱')
@section('css')
    <link rel="stylesheet" href="{{asset('css/admin.css')}}">
@stop
@section('body-class','login-bg')
@section('container')
    <div class="login layui-anim" id="login">
        <div class="message">玩转互娱 - 管理登录</div>
        <div id="darkbannerwrap"></div>
        <form class="login-form">
            <input name="account" placeholder="账号" value="{{old('account')}}" type="text">
            <hr class="hr15">
            <input name="password" placeholder="密码" type="password">
            <hr class="hr15">
            <input value="登录" style="width:100%;" onclick="return false" type="submit" id="submit">
            <hr class="hr20">
        </form>
    </div>
@stop
@section('js-lib')
    <script src="{{asset('js/layer/layer.js')}}"></script>
@stop
@section('js')
    <script>
        $(function () {
            jinono.login.init();
        });
    </script>
@stop