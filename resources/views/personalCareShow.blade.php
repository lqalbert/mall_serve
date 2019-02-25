<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>护理方案</title>
    <style>
        .wrap{
            width: 1200px;
            margin:0 auto;
            background-color: #FCFCFC;
            padding: 5px;
        }
        .f1{
            width: 100%;
            height:76px;
            overflow: hidden;
        }
        .f1 .f1-1{
            float: left;
        }
        .f1 .f1-1 img{
            width: 100px;
            height: 80px;
        }
        .f1 .f1-2{
            text-align: center;
            font-size: 30px;
            font-weight: bolder;
            line-height: 76px;
            float: left;
            position: relative;
            top:0;
            left:350px;
        }
        .f1 .f1-3{
            float: right;
        }
        .f1 .f1-3 img{
            width: 100px;
            height: 50px;
            position: relative;
            top:-4px;
            right:-90px;
        }
        .f1 .f1-3 span{
            float:right;
            position: relative;
            top:50px;
            right:0;
            font-size: 12px;
        }
        .f2-1{
            display:inline-block;
            margin: 5px 500px 5px 0;
        }
        .f3 h3{
            text-align: center;
        }
        table.pro{
            width: 1200px;
        }
        table.pro th{
            color: white;
            background-color: #6E2C9F;
            height: 34px;
            line-height: 34px;
        }
        table.pro td{
            background-color: #FCFCFC;
            text-align: center;
            padding: 5px 2px;
        }
    </style>
</head>
<body>
    <div class="wrap">
        <div class="f1">
            <div class="f1-1"><img src="/images/logo.png" ></div>
            <div class="f1-2">{{$data['user_name']}}的私人护理方案</div>
            <div class="f1-3">
                <img src="/images/code.png" >
                <span>{{$data['plan_num']}}</span>
            </div>
        </div>
        <hr>
        <div class="f2">
            <span class="f2-1">姓名：{{$data['user_name']}}</span>
            <span>性别：{{$data['user_sex']}}</span>
            <br>
            <p>编号：{{$data['plan_num']}}</p>
        </div>
        <hr>
        <div class="f3">
            <div>
                <h4>问题诊断:</h4>
                {{$data['diagnosis']}}
            </div>
            <div>
                <h4>解决方案:</h4>
                {{$data['deal_plan']}}
            </div>
            <div>
                <h3>护肤方案</h3>
                <table class="pro" border="1" cellpadding="0" cellspacing="0">
                    <tr>
                        <th width="220px">护肤产品名称</th>
                        <th>产品功效</th>
                        <th width="100px">单价</th>
                        <th width="100px">数量</th>
                    </tr>
                    @foreach($pro as $v)
                    <tr>
                        <td style="background-color: #f5f5f5">{{$v->goods_name}}</td>
                        <td>{{$v->efficacy}}</td>
                        <td>￥{{$v->price}}</td>
                        <td>X{{$v->goods_number}}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td style="text-align: right; padding-right: 20px" colspan="4">合计：<span style="color: red">￥{{$data['sum']}}</span></td>
                    </tr>
                    <tr>
                        <td  colspan="4">
                            护肤机构：<span style="text-decoration: underline; display: inline-block;margin-right: 200px">{{$data['organization']}}</span>
                            导师签名：<span style="text-decoration: underline; display: inline-block;margin-right: 200px">{{$data['sign']}}</span>
                            报告日期：<span style="text-decoration: underline">{{$data['updated_at']}}</span>
                        </td>
                    </tr>
                </table>
            </div>
            <div>
                <h4>使用方法：</h4>
                {{$data['introduction']}}
            </div>
            <hr size="1" noshade="noshade" style="border:1px black dashed;"/>
        </div>
    </div>
</body>
</html>
