<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="chrome=1,IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}商城后台管理系统</title>

    <!-- Styles -->
<!--     <link href="{{ asset('css/app.css') }}" rel="stylesheet"> -->
	<!-- ><script src="https://cdn.jsdelivr.net/npm/promise-polyfill@7/dist/polyfill.min.js"></script>< -->
     <link href="/admin/static1.1.16/css/app.5a568e911cb6edfce4f1e9f2319edc86.css" rel="stylesheet">
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
	<script type="text/javascript" src="/admin/static1.1.16/js/manifest.0ff705a14fe535e10e58.js"></script>
    <script type="text/javascript" src="/admin/static1.1.16/js/vendor.97cddee02d1dbc0846b4.js"></script>
    <script type="text/javascript" src="/admin/static1.1.16/js/app.fd579a7f16ec19c2f503.js"></script>
</body>
</html>