<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link rel="shortcut icon" href="{{URL::asset('favicon.ico')}}">
    <link rel="stylesheet" href="{{URL::asset('lib/uikit/css/uikit.min.css')}}">
    <link rel="stylesheet" href="{{URL::asset('css/common.css')}}">
    <link rel="stylesheet" href="{{URL::asset('css/app.css')}}">

    <script src="{{URL::asset('js/jquery.min.js')}}"></script>
    <script src="{{URL::asset('lib/uikit/js/uikit.min.js')}}"></script>
    <script src="{{URL::asset('lib/uikit/js/uikit-icons.min.js')}}"></script>
    <script src="{{URL::asset('js/jinono.js')}}"></script>
</head>

<body>
<div id="login" style="background-color: #fafafa;padding: 30px 0;margin-top: 150px">
    <img src="{{URL::asset('img/jinono.png')}}" style="width: 100px;margin: 15px 0">
    <span class="input input--hoshi">
			<input class="input__field input__field--hoshi" type="text" name="mobile" onkeyup="value=value.replace(/[^\d]/g,'')" maxlength="13">
					<label class="input__label input__label--hoshi input__label--hoshi-color-1">
						<span class="input__label-content input__label-content--hoshi">手机号</span>
					</label>
		    </span>
    <div class="mobile_message"></div>

    <span class="input input--hoshi">
			<input class="input__field input__field--hoshi" type="text" name="code" onkeyup="value=value.replace(/[^\d]/g,'')" maxlength="6">
					<label class="input__label input__label--hoshi input__label--hoshi-color-1">
						<span class="input__label-content input__label-content--hoshi">验证码</span>
					</label>
		    </span>
    <div class="code_message"></div>
    <a href="javascript:void(0);" class="get_sms">获取短信验证</a>

    <button id="submit" class="uk-button uk-button-primary uk-width-1-1 uk-margin-small-bottom">登 陆</button>
    <ul class="other_login_nav">
        <li class="other_login"><a href="javascript:void(0);"><img class="logo" src="{{URL::asset('img/github.png')}}"></a></li>
        <li class="other_login"><a href="javascript:void(0);"><img class="logo" src="{{URL::asset('img/qq.png')}}"></a></li>
        <li class="other_login"><a href="javascript:void(0);"><img class="logo" src="{{URL::asset('img/weibo.png')}}"></a></li>
        <li class="other_login"><a href="javascript:void(0);"><img class="logo" src="{{URL::asset('img/google.png')}}"></a></li>
        <li class="clear_both"></li>
    </ul>
</div>
</body>
<script>
    $(function () {
        jinono.login.init();
    });
</script>
</html>
