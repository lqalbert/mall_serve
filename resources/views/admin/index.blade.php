<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
<!--     <link href="{{ asset('css/app.css') }}" rel="stylesheet"> -->
	<!-- ><script src="https://cdn.jsdelivr.net/npm/promise-polyfill@7/dist/polyfill.min.js"></script>< -->
    <link href="/admin/static1.0.21/css/app.93a5d2096f879d18f8002b89540644e4.css" rel="stylesheet">
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
	<script type="text/javascript" src="/admin/static1.0.21/js/manifest.a79cc6c730c75ce82295.js"></script>
    <script type="text/javascript" src="/admin/static1.0.21/js/vendor.18c8cadfa9001265e9df.js"></script>
    <script type="text/javascript" src="/admin/static1.0.21/js/app.d8b5037d38ba0bf9c513.js"></script>
</body>
</html>