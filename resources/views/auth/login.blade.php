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
    <script src="{{URL::asset('js/jinono.js')}}"></script>
    <style>
        #canvas {
            width: 100%;
            height: auto;
            overflow: hidden;
            position: absolute;
            top: 0;
            left: 0;
            background-color: #1a1724;
        }

        .canvas-wrap {
            position: relative;

        }

        div.canvas-content {
            position: relative;
            z-index: 2000;
            color: #fff;
            text-align: center;
            padding-top: 30px;
        }
    </style>
</head>

<body>
<div style="position: absolute;width: 100%">
    <div id="login">
        <img src="{{URL::asset('img/jinono.png')}}" style="width: 100px;margin: 15px 0">
        <span class="input input--hoshi">
			<input class="input__field input__field--hoshi" type="text" name="account" maxlength="16">
					<label class="input__label input__label--hoshi input__label--hoshi-color-1">
						<span class="input__label-content input__label-content--hoshi">账户</span>
					</label>
		    </span>
        <div class="account_message"></div>

        <span class="input input--hoshi">
			<input class="input__field input__field--hoshi" type="text" name="password" maxlength="16">
					<label class="input__label input__label--hoshi input__label--hoshi-color-1">
						<span class="input__label-content input__label-content--hoshi">密码</span>
					</label>
		    </span>
        <div class="password_message"></div>

        <button id="submit" class="uk-button uk-button-primary uk-width-1-1 uk-margin-small-bottom">登 陆</button>
    </div>
</div>


<section class="canvas-wrap">
    <div class="canvas-content">

    </div>
    <div id="canvas" class="gradient"></div>
</section>

</body>
<script>
    $(function () {
        var url = '{{url('/login')}}';
        var redirect = '{{url('/')}}';
        jinono.login.init(url,redirect);
    });
</script>
<!--canvas -->
<script src="{{URL::asset('lib/canvas/three.min.js')}}"></script>
<script src="{{URL::asset('lib/canvas/projector.js')}}"></script>
<script src="{{URL::asset('lib/canvas/canvas-renderer.js')}}"></script>
<script src="{{URL::asset('lib/canvas/3d-lines-animation.js')}}"></script>
<script src="{{URL::asset('lib/canvas/color.js')}}"></script>
</html>
