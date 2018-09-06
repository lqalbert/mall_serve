@extends('home.base')
@section('css')
    <link rel="stylesheet" href="../css/home/login/register.css"/>
@endsection
@section('content')
    <div id="registerContent" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 col-xs-12 registerForm">
            <form action="" id="registerFrom">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 title">
                    基本信息
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 line">
                    <div class="diamond"></div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 registerBar">
                    <div class="col-lg-2 col-md-2 col-sm-3 col-xs-3 leftBar">
                        姓名
                        <span style="color: red">*</span>
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-7 col-xs-8 rightBar">
                        <input id="user" type="text" name="username" placeholder="请输入姓名">
                        <div class="message"></div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 registerBar">
                    <div class="col-lg-2 col-md-2 col-sm-3 col-xs-3 leftBar">
                        年龄
                        <span style="color: red">*</span>
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-7 col-xs-8 rightBar">
                        <input id="age" type="text" name="age" placeholder="请填写年龄">
                        <div class="message"></div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 registerBar">
                    <div class="col-lg-2 col-md-2 col-sm-3 col-xs-3 leftBar">
                        手机号
                        <span style="color: red">*</span>
                    </div>
                        <div class="col-lg-8 col-md-8 col-sm-7 col-xs-8 rightBar">
                        <input id="phone" type="text" name="phone" placeholder="输入你的手机号">
                        <div class="message"></div>
                        </div>
                </div>
                <div class="col-lg-8 col-lg-offset-2 col-md-8 col-md-offset-2 col-sm-7 col-sm-offset-3 col-xs-8 col-xs-offset-3 registerAction">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="register">前往问卷页</div>
                    <div class="message"></div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function () {
            $('.agreeContent .checkB').on('click',function () {
                if($(this).html()==''){
                    $(this).html('<span></span>')
                }else{
                    $(this).html('')
                }
            })
            $('#register').on('click',function () {
                var flg=true;
                var name=$('#user').val();
                var age=$('#age').val();
                var phone=$('#phone').val();
                /*------正则验证-----*/
                /*----------验证用户名----------*/
                var userP=/^[a-zA-Z][a-zA-Z0-9]{3,19}$/;
                if(name==''){
                    $('#user').siblings('.message').text('用户名不能为空')
                    flg=false
                }else{
                    // if(!userP.test(name)){
                    //     $('#user').siblings('.message').text('用户名格式有误')
                    //     flg=false
                    // }else{
                    //     $('#user').siblings('.message').text('')
                    // }
                }
                /*---------验证年龄---------*/
                var ageP=/^[1-9][0-9]$/;
                if(age==''){
                    $('#age').siblings('.message').text('年龄不能为空')
                    flg=false
                }else{
                    if(!ageP.test(age)){
                        $('#age').siblings('.message').text('年龄输入不合理')
                        flg=false
                    }else{
                        $('#age').siblings('.message').text('')
                    }
                }
                /*-------验证手机----*/
                var phonePat=/^1[34578]\d{9}$/;
                if(phone==''){
                    $('#phone').siblings('.message').text('手机号不能为空')
                    flg=false
                }else{
                    if(!phonePat.test(phone)){
                        $('#phone').siblings('.message').text('手机格式有误')
                        flg=false
                    }else{
                        $('#phone').siblings('.message').text('')
                    }
                }
                if(flg){
                    $.ajax({
                        url:"/register-action",
                        type:'POST',
                        dataType: 'json',
                        data:{
                            name:name,
                            age:age,
                            phone:phone
                        },
                        success:function (res) {
                            if(res['status']== 1){
                                $('form')[0].reset();
                                window.location.href="/information/index/"+{{$id}};
                            }else{
                                $('#register').siblings('.message').text(res['msg'])
                            }
                        }
                    })
                }
            })
        })
    </script>
@endsection