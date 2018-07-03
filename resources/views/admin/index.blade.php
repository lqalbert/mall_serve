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
    <link href="/admin/static1.1.35/css/app.48ae626d86fa9473ea8b4bb554c81589.css" rel="stylesheet">
</head>
<body>
    <div id="app">
    </div>
<!-- 	<script> 
// 	//给IE10的 上面的 条件注释在IE10以上的浏览器不起作用了y
//     if(isIE = navigator.userAgent.indexOf("MSIE")!=-1) { 
//         var h = document.getElementsByTagName('head');
//         var scr = document.createElement('script');
//         scr.setAttribute('src', 'https://cdn.jsdelivr.net/npm/promise-polyfill@7/dist/polyfill.min.js');
//         h[0].appendChild(scr);
//     } 
   </script>-->
    <!-- Scripts -->
	<script type="text/javascript" src="/admin/static1.1.35/js/manifest.6b103a9e894a0a5899c6.js"></script>
    <script type="text/javascript" src="/admin/static1.1.35/js/vendor.0c122c06ebcaba843bc4.js"></script>
    <script type="text/javascript" src="/admin/static1.1.35/js/app.4b3cdb42233c89678a94.js"></script>
    <script type="text/javascript" src="/admin/static1.1.35/js/babel-polyfill.9e41b68c2bb89c9472cf.js"></script>
</body>
</html>
