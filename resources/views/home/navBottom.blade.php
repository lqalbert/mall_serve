<div class=" navBottom">
    <div class="container">
    	<div class="row navBot">
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 box">
                    <div class="title">关于普拉她</div>
                    <div class="">
                        <a href="{{URL('brand/index')}}">
                            品牌故事
                        </a>
                    </div>
                    <div class=""><a href="{{URL('information/company')}}">公司信息</a></div>
                </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 box">
                    <div class="title">美丽帮助</div>
                    <div class="">
                        {{----}}
                        <a href="{{URL('information/news')}}">
                            美丽资讯
                        </a>
                    </div>
                    <div class="">
                        {{--{{URL('connection/technology')}}--}}
                        <a href="{{URL('connection/technology')}}">
                            技术咨询
                        </a>
                    </div>
                    {{--<div class="">0371-888888</div>--}}
                </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 box">
                    <div class="title">客户服务</div>
                    <div class="">
                        
                        <a href="{{URL('question/index')}}">
                            常见问题
                        </a>
                    </div>
                    <div class=""><a href="{{ action('Home\QuestionController@index') }}?{{ http_build_query(['exchange'=>1])}}">退换货问题</a></div>
                </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 box">
                    <div class="title">联系我们</div>
                    <div class="">微商城</div>
                    <div class="">公众号</div>
                </div>
            <div id="weiCode">
                <img src="/images/code.jpg" alt="">
                <div class="minCode">
                    <img src="/images/code.jpg" alt="">
                </div>
            </div>
        </div>
        
    </div>
    <div class="navNum">
        备案号：<a href="http://www.miibeian.gov.cn" target="_blank">粤ICP备18050024</a> 广州普拉她生物科技有限公司&nbsp;&nbsp;
        <span class="phone">咨询热线  400-158-2369</span>
    </div>
</div>