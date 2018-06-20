<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>打印{{ config('app.name', 'Laravel') }}</title>
    <link  rel="stylesheet" href="/css/bootstrap.min.css">
    <style type="text/css" media="print">
        html,body{
            width: 240mm;
            font-size: 12pt;
            height:auto;
        }
        .text-center {
            text-align: center;
        }
        td {
            text-align:center;
        }
        h1{
            font-size: 30pt;
            height: 13mm;
            line-height:13mm;
/*             line-height:10mm; */
            margin: 5mm auto 5mm;
        }
        .container{
/*             width: 180mm; */
            width: 240mm;
            margin: 0 auto;
        }
        .subtitle {
            font-size: 13pt;
            line-height: 15mm;
        }
        .head-td{
            width: 25mm;
            height: 12mm;
        }
        .order{
/*             border: 1mm solid #666; */
/*             border-radius: 4px; */
             border-collapse:collapse;
        }
        .order td {
            border: 1mm solid black;
        }
        
        table.order tr:last-child td:first-child {
            border-bottom-left-radius: 4px;
        }
        
        table.order tr:last-child td:last-child {
            border-bottom-right-radius: 4px;
        }
        .goods{
            border: 1.5mm solid black;
            border-collapse:collapse;
            
            margin-top: 5mm;
        }
        .goods td {
            border: 1mm solid #666;
        }
        .goods-td{
            height: 12mm;
            width: 20mm;
        }
        .text-left {
            text-align:left ;
        }
        td.text-left{
            text-indent: 3mm;
        }
        .text-right {
            text-align: right !important;
        }
        button{
            display:none;
        }
        .logo{
            background-image: url("/images/print_logo.fw.png");
            background-repeat: no-repeat;
            background-position: left center;
        }
    </style>
    <style type="text/css">
 
        body{
            padding: 0 10px;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        table {
            width: 100%;
        }
/*         th { */
/*             width: 100px; */
/*         } */
/*         th,td{ */
/*             text-indent: 5px; */
/*         } */
.logo{
            background-image: url("/images/print_logo.fw.png");
            background-repeat: no-repeat;
            background-position: left center;
        }
    </style>
</head>
<body>
	<div class="container " style="position: relative;">
		<img src="/images/print_logo.fw.png" style="vertical-align:middle; position:absolute; 0px" width="130"/>
        <h1 class="text-center">宝贝清单</h1>
	</div>
    <div class="container">
    	<div class="subtitle　text-right" style="float: right">郑州普拉她</div>
    	
    	<table class="order">
    		<tr>
    			<td class="head-td">VIP</td>
    			<td class="text-left">张三</td>
    			<td class="head-td">日期</td>
    			<td class="text-left">2014-05-05</td>
    		</tr>
    		<tr>
    			<td class="head-td">电话</td>
    			<td class="text-left">argaergaeg</td>
    			<td class="head-td">单号</td>
    			<td class="text-left">aergaerg</td>
    		</tr>
    	</table>
    	<table class="goods">
    		<tr>
    			<td class="goods-td">序号</td>
    			<td>宝贝名称</td>
    			<td class="goods-td">数量</td>
    		</tr>
    		
    		<tr>
    			<td class="goods-td">1</td>
    			<td class="text-left">[数量]代码+品名+规格</td>
    			<td class="goods-td">12</td>
    		</tr>
    		
    		<tr>
    			<td class="goods-td">备注</td>
    			<td class="text-left">总数:</td>
    			<td class="goods-td"></td>
    			
    		</tr>
    	</table>
    	<button onclick="window.print()">打印</button>
    </div>
	
	<script>
		window.print();
	</script>
</body>
</html>