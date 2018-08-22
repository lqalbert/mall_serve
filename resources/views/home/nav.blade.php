<nav id="navbar" class="navbar navbar-fixed-top">
    <div class="headBar">
            	<div class="container">
            		<div class="navbar-header" style="padding: 0">
                        <button id="navBut" type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
            		<div class="row">
            			<div class="col-lg-2 col-md-2 col-sm-3 col-xs-12 logoImg">
                            <img src="/images/home/index/logo.png" alt="">
                        </div>
            			<div class="col-lg-7 col-md-7 col-sm-6 col-xs-12">
                    <!-- Brand and toggle get grouped for better mobile display -->
                            <div class="collapse navbar-collapse " id="bs-example-navbar-collapse-1">
                                    <ul id="ul" class="nav nav-justified">
                                        <li role="presentation" class="active">
                                            <a href="/" class="{{$bar['bar1']}}">
                                                首页
                                                <div class="{{$bar['line1']}}"></div>
                                            </a>
                                        </li>
                                        
                                        <li role="presentation">
                                            <a href="{{URL('product/index')}}" class="{{$bar['bar2']}}">
                                                所有产品
                                                <div class="{{$bar['line2']}}"></div>
                                            </a>
                                        </li>
                                        <li role="presentation">
                                            <a href="{{URL('sale/index')}}" class="{{$bar['bar3']}}">
                                                畅销榜单
                                                <div class="{{$bar['line3']}}"></div>
                                            </a>
                                        </li>
                                        
                                        <li role="presentation"><a href="{{route('product/index', ['cate_id'=>1])}}" class="{{$bar['bar4']}}">
                                                护肤
                                                <div class="{{$bar['line4']}}"></div>
                                            </a>
                                        </li>
                                        <li role="presentation"><a href="{{route('product/index', ['cate_id'=>2])}}" class="{{$bar['bar5']}}">
                                                彩妆
                                                <div class="{{$bar['line5']}}"></div>
                                            </a>
                                        </li>
                                        <li role="presentation"><a href="{{URL('brand/index')}}" class="{{$bar['bar6']}}">
                                                品牌故事
                                                <div class="{{$bar['line6']}}"></div>
                                            </a>
                                        </li>
                                    </ul>
                                    </ul>
                                </div>
               			 </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <div class="searchBox">
                                <input type="text" id="search" placeholder="寻找美丽新世界">
                                <span id="souI" class="glyphicon glyphicon-search" aria-hidden="true"></span>
                            </div>
                        </div>
            		</div>
            	</div>
                
            </div>
        
    
</nav>