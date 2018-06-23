<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}商城后台管理系统</title>

    <!-- Styles -->
<!--     <link href="{{ asset('css/app.css') }}" rel="stylesheet"> -->
	<!-- ><script src="https://cdn.jsdelivr.net/npm/promise-polyfill@7/dist/polyfill.min.js"></script>< -->
    <link href="/admin/static1.1.16/css/app.2c33a592ae43ee32177e0d082c4492bb.css" rel="stylesheet">
</head>
<body>
    <div id="app">
    </div>
	<script>
	//给IE10的 上面的 条件注释在IE10以上的浏览器不起作用了y
    if(isIE = navigator.userAgent.indexOf("MSIE")!=-1) { 
        var h = document.getElementsByTagName('head');
        var scr = document.createElement('script');
        scr.setAttribute('src', 'https://cdn.jsdelivr.net/npm/promise-polyfill@7/dist/polyfill.min.js');
        h[0].appendChild(scr);
    } 
   </script>
    <!-- Scripts -->
	<script type="text/javascript" src="/admin/static1.1.16/js/manifest.ba089eb9fb185d76a6de.js"></script>
    <script type="text/javascript" src="/admin/static1.1.16/js/vendor.78209d53ebd12fb5afbb.js"></script>
    <script type="text/javascript" src="/admin/static1.1.16/js/app.eec74b27cd1cb61697ab.js"></script>
</body>
</html>
