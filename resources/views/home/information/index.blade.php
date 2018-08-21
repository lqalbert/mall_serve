@extends('home.base')

@section('css')
    <link rel="stylesheet" href="/css/home/information/index.css"/>
@endsection

@section('nav')
@include("home.nav",['bar' => $bar])
@endsection

@section('content')
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 protectContent">

        <div class="col-lg-6 col-lg-offset-3 col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-12 lle">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 protectForm">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 formTitle">
                    {{$title['title']}}:
                </div>
                <form action="">
                    <input type="text" name="questionnaire_managements_id" value="{{$title['id']}}" hidden>
                    @foreach ($questionnaires as $k => $questionnaire)
                    <div  class="col-lg-12 col-md-12 col-sm-12 col-xs-12 formList">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 questionT">
                            问题{{$k+1}} &nbsp;&nbsp;&nbsp;{{$questionnaire['topic_name']}}？
                        </div>
                        {{--单项选择型--}}
                        @if($questionnaire['problem_type']==1)
                        <div>
                        @if($questionnaire['option_a'])
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 questionL">
                            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-2">
                                <input type="radio" name="question_{{$questionnaire['id']}}"  class="question1" value="answer_a">
                            </div>
                            <div class="col-lg-11 col-md-11 col-sm-11 col-xs-10">
                                {{$questionnaire['option_a']}}
                            </div>
                        </div>
                        @endif
                        @if($questionnaire['option_b'])
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 questionL">
                            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-2">
                                <input type="radio" name="question_{{$questionnaire['id']}}" class="question1" value="answer_b">
                            </div>
                            <div class="col-lg-11 col-md-11 col-sm-11 col-xs-10">
                                {{$questionnaire['option_b']}}
                            </div>
                        </div>
                        @endif
                        @if($questionnaire['option_c'])
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 questionL">
                            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-2">
                                <input type="radio" name="question_{{$questionnaire['id']}}" class="question1" value="answer_c">
                            </div>
                            <div class="col-lg-11 col-md-11 col-sm-11 col-xs-10">
                                {{$questionnaire['option_c']}}
                            </div>
                        </div>
                        @endif
                        @if($questionnaire['option_d'])
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 questionL">
                            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-2">
                                <input type="radio" name="question_{{$questionnaire['id']}}" class="question1" value="answer_d">
                            </div>
                            <div class="col-lg-11 col-md-11 col-sm-11 col-xs-10">
                                {{$questionnaire['option_d']}}
                            </div>
                        </div>
                        @endif
                        @if($questionnaire['option_e'])
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 questionL">
                            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-2">
                                <input type="radio" name="question_{{$questionnaire['id']}}" class="question1" value="answer_e">
                            </div>
                            <div class="col-lg-11 col-md-11 col-sm-11 col-xs-10">
                                {{$questionnaire['option_e']}}
                            </div>
                        </div>
                        @endif
                        </div>
                        {{--多项选择型--}}
                        @elseif($questionnaire['problem_type']==2)
                        <div>
                            @if($questionnaire['option_a'])
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 questionL">
                                    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-2">
                                        <input type="checkbox" name="question_{{$questionnaire['id']}}"  class="question1 'question_'+{{$k+1}}" value="answer_a">
                                    </div>
                                    <div class="col-lg-11 col-md-11 col-sm-11 col-xs-10">
                                        {{$questionnaire['option_a']}}
                                    </div>
                                </div>
                            @endif
                            @if($questionnaire['option_b'])
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 questionL">
                                    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-2">
                                        <input type="checkbox" name="question_{{$questionnaire['id']}}" class="question1 'question_'+{{$k+1}}" value="answer_b">
                                    </div>
                                    <div class="col-lg-11 col-md-11 col-sm-11 col-xs-10">
                                        {{$questionnaire['option_b']}}
                                    </div>
                                </div>
                            @endif
                            @if($questionnaire['option_c'])
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 questionL">
                                    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-2">
                                        <input type="checkbox" name="question_{{$questionnaire['id']}}" class="question1 'question_'+{{$k+1}}" value="answer_c">
                                    </div>
                                    <div class="col-lg-11 col-md-11 col-sm-11 col-xs-10">
                                        {{$questionnaire['option_c']}}
                                    </div>
                                </div>
                            @endif
                            @if($questionnaire['option_d'])
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 questionL">
                                    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-2">
                                        <input type="checkbox" name="question_{{$questionnaire['id']}}" class="question1 'question_'+{{$k+1}}" value="answer_d">
                                    </div>
                                    <div class="col-lg-11 col-md-11 col-sm-11 col-xs-10">
                                        {{$questionnaire['option_d']}}
                                    </div>
                                </div>
                            @endif
                            @if($questionnaire['option_e'])
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 questionL">
                                    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-2">
                                        <input type="checkbox" name="question_{{$questionnaire['id']}}" class="question1 'question_'+{{$k+1}}" value="answer_e">
                                    </div>
                                    <div class="col-lg-11 col-md-11 col-sm-11 col-xs-10">
                                        {{$questionnaire['option_e']}}
                                    </div>
                                </div>
                            @endif
                        </div>
                        {{--文字填写型--}}
                        @else
                            <div >
                                <textarea  name="question_{{$questionnaire['id']}}" style="height: 100px" class="form-control"  placeholder="请填写"></textarea>
                            </div>
                        @endif
                    </div>
                    @endforeach

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 userPhone">
                        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                            <label class="control-label col-lg-12 col-md-12 col-sm-12 col-xs-12" for="inputSuccess2">联系方式:</label>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                            <input type="number" name="cus_phone" class="form-control" id="inputSuccess2" placeholder="手机号">
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 userPhone">
                        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                            <label class="control-label col-lg-12 col-md-12 col-sm-12 col-xs-12">验证码：</label>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 codeBox">
                            <input type="text" name="code" class="form-control" placeholder="请输入验证码">
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 imgBox">

                            <img src="{{URL('/verification-code')}}" alt="" id="codeChange" onclick="againCode()">
                            {{--<img src="{{captcha_src()}}" alt=""  onclick="this.src='{{captcha_src()}}'+Math.random()">--}}
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 butBox">
                        <div class="but" id="but">提交</div>
                    </div>
                </form>


            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src=""></script>
    <script src="/js/jquery-3.2.1.min.js"></script>
    <script>
        function againCode(){
            $.ajax({
                url: '/verification-code',
                type: 'GET',
                success: function(data){
                    if(data){
                        var urls =$('#codeChange').attr('src');
                        $("#codeChange").attr('src', urls);
                    }else{
                        alert("刷新验证码失败！");
                    }
                }
            })
        }
        $("#but").click(function(){
            var formArray = $("form").serializeArray();
            var formData = {};
            $.map(formArray, function (n, i) {
                if(formData[n['name']]){
                    formData[n['name']] += ',' + n['value'];
                }else{
                    formData[n['name']] = n['value'];
                }
            });
            $.ajax({
                url: '/save-user-answers',
                type: 'POST',
                dataType: 'json',
                data: formData,
                success:function(response){
                    if(response.status){
                        $('form')[0].reset();
                        alert(response.msg);
                    }else{
                        $('form')[0].reset();
                        alert(response.msg);
                    }
                },
                error:function(response){
                    alert("联系我们！");
                }
            });

        });
    </script>

@endsection