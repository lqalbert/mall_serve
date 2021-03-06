<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name', '商城') }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="/32.ico" />
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/swiper.min.css"/>
    <link rel="stylesheet" href="/css/home/newweb.css"/>
</head>
<body>
<!--导航-->
@include("home.nav", ['nav'=>'index'])
<!--/ 内容区域-->
<!--/ banner-->
<div class="container-fluid maxBanner">
    <div class="swiper-container">
        <div class="swiper-wrapper">
        	
            <div class="swiper-slide">
                <a href="#"><img src="/images/web/banner1.png" alt=""></a>
            </div>
            <div class="swiper-slide">
                <a href="/product/index?cate_id=10"><img src="/images/web/banner2.jpg" alt=""></a>
            </div>
            <div class="swiper-slide">
                <a href="/product/index?cate_id=3"><img src="/images/web/banner3.png" alt=""></a>
            </div>
            <div class="swiper-slide">
                <a href="/product/39"><img src="/images/web/banner4.png" alt=""></a>
            </div>
        </div>
        <!-- Add Pagination -->
        <div class="swiper-pagination"></div>
        <!-- Add Arrows -->
        <div class="swiper-button-next swiper-button-white"></div>
        <div class="swiper-button-prev swiper-button-white"></div>
    </div>
</div>
<!--/ minbanner-->
<div class="container minBanner">
    <div class="col-lg-12 col-md-12 minTab">
        <div class="row">
            <div class="col-lg-2 col-md-2 tabList">
                <div class="col-lg-12 col-md-12 con">
                    <div class="col-lg-12 col-md-12 bg active">
                        臻品面膜系列
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-2 tabList">
                <div class="col-lg-12 col-md-12 con">
                    <div class="col-lg-12 col-md-12 bg">
                        金致焕肌系列
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-2 tabList">
                <div class="col-lg-12 col-md-12 con">
                    <div class="col-lg-12 col-md-12 bg">
                        水嫩保湿系列
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-2 tabList">
                <div class="col-lg-12 col-md-12 con">
                    <div class="col-lg-12 col-md-12 bg">
                        美妆系列
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-2 tabList">
                <div class="col-lg-12 col-md-12 con">
                    <div class="col-lg-12 col-md-12 bg">
                        滋润护肤
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-2 tabList">
                <div class="col-lg-12 col-md-12 con">
                    <div class="col-lg-12 col-md-12 bg">
                        保健食品系列
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12 col-md-12 minCon">
        <div class="col-lg-12 col-md-12 conList mianmo">
            <div class="row">
                <div class="col-lg-4 col-md-4 cons">
                    <div class="col-lg-12 col-md-12 bg">
                        <div class="col-lg-12 col-md-12 img">
                            <a href="/product/21" target="_blank">
                                <img src="/images/web/mianmo1.png" alt="">
                            </a>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <div class="line"></div>
                        </div>
                        <div class="col-lg-12 col-md-12 textA volum">VC匀净面膜 26ml*5片</div>
                        <div class="col-lg-12 col-md-12 textA description">·自带滤镜 美白莹润·</div>
                        <div class="col-lg-12 col-md-12 textA price"><span>￥</span>88</div>
                        <div class="col-lg-12 col-md-12 textA checkDetail">
                            <div class="check"><a href="/product/21" target="_blank">查看详情</a></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 cons">
                    <div class="col-lg-12 col-md-12 bg">
                        <div class="col-lg-12 col-md-12 img">
                        	<a href="/product/20" target="_blank">
                            	<img src="/images/web/mianmo2.png" alt="">
                            </a>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <div class="line"></div>
                        </div>
                        <div class="col-lg-12 col-md-12 textA volum">净透焕颜黑面膜 26ml*5片</div>
                        <div class="col-lg-12 col-md-12 textA description">·澄净如初 细腻净透·</div>
                        <div class="col-lg-12 col-md-12 textA price"><span>￥</span>118</div>
                        <div class="col-lg-12 col-md-12 textA checkDetail">
                            <div class="check"><a href="/product/20" target="_blank">查看详情</a></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 cons">
                    <div class="col-lg-12 col-md-12 bg">
                        <div class="col-lg-12 col-md-12 img">
                            <a href="/product/22" target="_blank">
                                <img src="/images/web/mianmo3.png" alt="">
                            </a>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <div class="line"></div>
                        </div>
                        <div class="col-lg-12 col-md-12 textA volum">蓝铜胜肽水光面膜 26ml*5片</div>
                        <div class="col-lg-12 col-md-12 textA description">·细致毛孔 自然提亮·</div>
                        <div class="col-lg-12 col-md-12 textA price"><span>￥</span>88</div>
                        <div class="col-lg-12 col-md-12 textA checkDetail">
                            <div class="check"><a href="/product/22" target="_blank">查看详情</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 conList fiveCon jinzhi">
            <div class="cons">
                <div class="col-lg-12 col-md-12 bg">
                    <div class="col-lg-12 col-md-12 img">
                        <a href="/product/26" target="_blank">
                            <img src="/images/web/jinzhi1.png" alt="">
                        </a>
                    </div>
                    <div class="col-lg-12 col-md-12">
                        <div class="line"></div>
                    </div>
                    <div class="col-lg-12 col-md-12 textA volum">金致焕肌精华水 120g</div>
                    <div class="col-lg-12 col-md-12 textA description">·清透润泽年轻态·</div>
                    <div class="col-lg-12 col-md-12 textA price"><span>￥</span>208</div>
                    <div class="col-lg-12 col-md-12 textA checkDetail">
                        <div class="check"><a href="/product/26" target="_blank">查看详情</a></div>
                    </div>
                </div>
            </div>
            <div class="cons">
                <div class="col-lg-12 col-md-12 bg">
                    <div class="col-lg-12 col-md-12 img">
                    	<a href="/product/24" target="_blank">
                        	<img src="/images/web/jinzhi2.png" alt="">	
                    	</a>
                    </div>
                    <div class="col-lg-12 col-md-12">
                        <div class="line"></div>
                    </div>
                    <div class="col-lg-12 col-md-12 textA volum">金致焕肌精华乳 100ml</div>
                    <div class="col-lg-12 col-md-12 textA description">·紧致提拉塑颜·</div>
                    <div class="col-lg-12 col-md-12 textA price"><span>￥</span>268</div>
                    <div class="col-lg-12 col-md-12 textA checkDetail">
                        <div class="check"><a href="/product/24" target="_blank">查看详情</a></div>
                    </div>
                </div>
            </div>
            <div class="cons">
                <div class="col-lg-12 col-md-12 bg">
                    <div class="col-lg-12 col-md-12 img">
                    	<a href="/product/25" target="_blank">
	                        <img src="/images/web/jinzhi3.png" alt="">
                    	</a>
                    </div>
                    <div class="col-lg-12 col-md-12">
                        <div class="line"></div>
                    </div>
                    <div class="col-lg-12 col-md-12 textA volum">金致焕肌精华霜 50g</div>
                    <div class="col-lg-12 col-md-12 textA description">·层层修护 绽现柔嫩·</div>
                    <div class="col-lg-12 col-md-12 textA price"><span>￥</span>306</div>
                    <div class="col-lg-12 col-md-12 textA checkDetail">
                        <div class="check"><a href="/product/25" target="_blank">查看详情</a></div>
                    </div>
                </div>
            </div>
            <div class="cons">
                <div class="col-lg-12 col-md-12 bg">
                    <div class="col-lg-12 col-md-12 img">
                        <a href="/product/23" target="_blank">
                            <img src="/images/web/jinzhi4.png" alt="">
                        </a>
                    </div>
                    <div class="col-lg-12 col-md-12">
                        <div class="line"></div>
                    </div>
                    <div class="col-lg-12 col-md-12 textA volum">金致焕肌洁颜乳 100g</div>
                    <div class="col-lg-12 col-md-12 textA description">·去角质 净透不紧绷·</div>
                    <div class="col-lg-12 col-md-12 textA price"><span>￥</span>118</div>
                    <div class="col-lg-12 col-md-12 textA checkDetail">
                        <div class="check"><a href="/product/23" target="_blank">查看详情</a></div>
                    </div>
                </div>
            </div>
            <div class="cons">
                <div class="col-lg-12 col-md-12 bg">
                    <div class="col-lg-12 col-md-12 img">
                        <a href="/product/27" target="_blank">
                            <img src="/images/web/jinzhi5.png" alt="">
                        </a>
                    </div>
                    <div class="col-lg-12 col-md-12">
                        <div class="line"></div>
                    </div>
                    <div class="col-lg-12 col-md-12 textA volum">金致焕肌精华液 30ml</div>
                    <div class="col-lg-12 col-md-12 textA description">·一瓶多效 奢养肌底·</div>
                    <div class="col-lg-12 col-md-12 textA price"><span>￥</span>278</div>
                    <div class="col-lg-12 col-md-12 textA checkDetail">
                        <div class="check"><a href="/product/27" target="_blank">查看详情</a></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 conList fiveCon shuinen">
            <div class="cons">
                <div class="col-lg-12 col-md-12 bg">
                    <div class="col-lg-12 col-md-12 img">
                    	<a href="/product/32" target="_blank">
	                        <img src="/images/web/shuinen1.png" alt="">
                    	</a>
                    </div>
                    <div class="col-lg-12 col-md-12">
                        <div class="line"></div>
                    </div>
                    <div class="col-lg-12 col-md-12 textA volum">水嫩保湿水 120g</div>
                    <div class="col-lg-12 col-md-12 textA description">·沁透吸收 水润光泽·</div>
                    <div class="col-lg-12 col-md-12 textA price"><span>￥</span>98</div>
                    <div class="col-lg-12 col-md-12 textA checkDetail">
                        <div class="check"><a href="/product/32" target="_blank">查看详情</a></div>
                    </div>
                </div>
            </div>
            <div class="cons">
                <div class="col-lg-12 col-md-12 bg">
                    <div class="col-lg-12 col-md-12 img">
                    	<a href="/product/30" target="_blank">
                        	<img src="/images/web/shuinen2.png" alt="">
                    	</a>
                    </div>
                    <div class="col-lg-12 col-md-12">
                        <div class="line"></div>
                    </div>
                    <div class="col-lg-12 col-md-12 textA volum">水嫩保湿乳 100ml</div>
                    <div class="col-lg-12 col-md-12 textA description">·滋养润泽 舒缓保湿·</div>
                    <div class="col-lg-12 col-md-12 textA price"><span>￥</span>178</div>
                    <div class="col-lg-12 col-md-12 textA checkDetail">
                        <div class="check"><a href="/product/30" target="_blank">查看详情</a></div>
                    </div>
                </div>
            </div>
            <div class="cons">
                <div class="col-lg-12 col-md-12 bg">
                    <div class="col-lg-12 col-md-12 img">
                        <a href="/product/31" target="_blank">
                            <img src="/images/web/shuinen3.png" alt="">
                        </a>
                    </div>
                    <div class="col-lg-12 col-md-12">
                        <div class="line"></div>
                    </div>
                    <div class="col-lg-12 col-md-12 textA volum">水嫩保湿霜 50g</div>
                    <div class="col-lg-12 col-md-12 textA description">·绽放柔嫩光彩·</div>
                    <div class="col-lg-12 col-md-12 textA price"><span>￥</span>136</div>
                    <div class="col-lg-12 col-md-12 textA checkDetail">
                        <div class="check"><a href="/product/31" target="_blank">查看详情</a></div>
                    </div>
                </div>
            </div>
            <div class="cons">
                <div class="col-lg-12 col-md-12 bg">
                    <div class="col-lg-12 col-md-12 img">
                    	<a href="/product/28" target="_blank">
	                        <img src="/images/web/shuinen4.png" alt="">
                    	</a>
                    </div>
                    <div class="col-lg-12 col-md-12">
                        <div class="line"></div>
                    </div>
                    <div class="col-lg-12 col-md-12 textA volum">水嫩保湿洁面乳 100g</div>
                    <div class="col-lg-12 col-md-12 textA description">·温和亲肤 深透清洁·</div>
                    <div class="col-lg-12 col-md-12 textA price"><span>￥</span>78</div>
                    <div class="col-lg-12 col-md-12 textA checkDetail">
                        <div class="check"><a href="/product/28" target="_blank">查看详情</a></div>
                    </div>
                </div>
            </div>
            <div class="cons">
                <div class="col-lg-12 col-md-12 bg">
                    <div class="col-lg-12 col-md-12 img">
                    	<a href="/product/29" target="_blank">
                            <img src="/images/web/shuinen5.png" alt="">
                    	</a>
                    </div>
                    <div class="col-lg-12 col-md-12">
                        <div class="line"></div>
                    </div>
                    <div class="col-lg-12 col-md-12 textA volum">水嫩保湿精华液 30ml</div>
                    <div class="col-lg-12 col-md-12 textA description">·一瓶多效 奢养肌底·</div>
                    <div class="col-lg-12 col-md-12 textA price"><span>￥</span>150</div>
                    <div class="col-lg-12 col-md-12 textA checkDetail">
                        <div class="check"><a href="/product/29" target="_blank">查看详情</a></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 conList meizhuang">
            <div class="row">
                <div class="col-lg-6 col-md-6 cons">
                    <div class="col-lg-12 col-md-12 bg">
                        <div class="col-lg-12 col-md-12 img">
                        	<a href="/product/39" target="_blank">
	                            <img src="/images/web/meizhuang1.png" alt="">
                        	</a>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <div class="line"></div>
                        </div>
                        <div class="col-lg-12 col-md-12 textA volum">美肌滤镜气垫霜 20g</div>
                        <div class="col-lg-12 col-md-12 textA description">·亮彩妆容 持久妆容·</div>
                        <div class="col-lg-12 col-md-12 textA price"><span>￥</span>198</div>
                        <div class="col-lg-12 col-md-12 textA checkDetail">
                            <div class="check"><a href="/product/39" target="_blank">查看详情</a></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 cons">
                    <div class="col-lg-12 col-md-12 bg">
                        <div class="col-lg-12 col-md-12 img">
                        	<a href="/product/37" target="_blank">
                                <img src="/images/web/meizhuang2.png" alt="">
                        	</a>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <div class="line"></div>
                        </div>
                        <div class="col-lg-12 col-md-12 textA volum">美肌滤镜精华粉底液 30ml</div>
                        <div class="col-lg-12 col-md-12 textA description">·缔造无暇丝缎肌·</div>
                        <div class="col-lg-12 col-md-12 textA price"><span>￥</span>258</div>
                        <div class="col-lg-12 col-md-12 textA checkDetail">
                            <div class="check"><a href="/product/37" target="_blank">查看详情</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 conList zirun">
            <div class="row">
                <div class="col-lg-4 col-md-4 cons">
                    <div class="col-lg-12 col-md-12 bg">
                        <div class="col-lg-12 col-md-12 img">
                        	<a href="/product/46" target="_blank">
	                            <img src="/images/web/zirun1.png" alt="">
                        	</a>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <div class="line"></div>
                        </div>
                        <div class="col-lg-12 col-md-12 textA volum">乳木果倍护滋润身体乳 150ml</div>
                        <div class="col-lg-12 col-md-12 textA description">·对抗干燥 保湿莹润·</div>
                        <div class="col-lg-12 col-md-12 textA price"><span>￥</span>69</div>
                        <div class="col-lg-12 col-md-12 textA checkDetail">
                            <div class="check"><a href="/product/46" target="_blank">查看详情</a></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 cons">
                    <div class="col-lg-12 col-md-12 bg">
                        <div class="col-lg-12 col-md-12 img">
                        	<a href="/product/47" target="_blank">
	                            <img src="/images/web/zirun2.png" alt="">
                        	</a>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <div class="line"></div>
                        </div>
                        <div class="col-lg-12 col-md-12 textA volum">樱花保湿莹润身体乳 150ml</div>
                        <div class="col-lg-12 col-md-12 textA description">·樱花淡香 温和护理·</div>
                        <div class="col-lg-12 col-md-12 textA price"><span>￥</span>69</div>
                        <div class="col-lg-12 col-md-12 textA checkDetail">
                            <div class="check"><a href="/product/47" target="_blank">查看详情</a></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 cons">
                    <div class="col-lg-12 col-md-12 bg">
                        <div class="col-lg-12 col-md-12 img">
                         <a href="/product/53" target="_blank">
                            <img src="/images/web/zirun3.png" style="max-width: 300px" alt="">
                        </a>                        
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <div class="line"></div>
                        </div>
                        <div class="col-lg-12 col-md-12 textA volum">花漾精萃护手霜 30ml*5</div>
                        <div class="col-lg-12 col-md-12 textA description">·深层莹润 温和护理·</div>
                        <div class="col-lg-12 col-md-12 textA price"><span>￥</span>66</div>
                        <div class="col-lg-12 col-md-12 textA checkDetail">
                            <div class="check"><a href="/product/53" target="_blank">查看详情</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 conList baojian">
            <div class="row">
                <div class="col-lg-6 col-md-6 cons">
                    <div class="col-lg-12 col-md-12 bg">
                        <div class="col-lg-12 col-md-12 img">
                        	<a href="/product/36" target="_blank">
                            	<img src="/images/web/baojian1.png" alt="">
                            </a>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <div class="line"></div>
                        </div>
                        <div class="col-lg-12 col-md-12 textA volum">她妍胶原蛋白固体饮料 90g (3g*30)</div>
                        <div class="col-lg-12 col-md-12 textA description">·胶原蛋白 重塑年轻态·</div>
                        <div class="col-lg-12 col-md-12 textA price"><span>￥</span>418</div>
                        <div class="col-lg-12 col-md-12 textA checkDetail">
                            <div class="check"><a href="/product/36" target="_blank">查看详情</a></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 cons">
                    <div class="col-lg-12 col-md-12 bg">
                        <div class="col-lg-12 col-md-12 img">
                        	<a href="/product/44" target="_blank">
                            	<img src="/images/web/baojian2.png" alt="">
                            </a>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <div class="line"></div>
                        </div>
                        <div class="col-lg-12 col-md-12 textA volum">她妍复合益生菌固体饮料 60g (2g*30)</div>
                        <div class="col-lg-12 col-md-12 textA description">·促进肠道吸收 改善问题肌肤·</div>
                        <div class="col-lg-12 col-md-12 textA price"><span>￥</span>298</div>
                        <div class="col-lg-12 col-md-12 textA checkDetail">
                            <div class="check"><a href="/product/44" target="_blank">查看详情</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid goldCon">
    <a href="/product/33" target="_blank">
        <img src="/images/web/gold1.png" alt="">
    </a>
    {{--<div class="container">
        --}}{{--<div class="textBox">
            <div class="col-lg-12 col-md-12 eText">Royale</div>
            <div class="col-lg-12 col-md-12 eText">Revitalizing</div>
            <div class="col-lg-12 col-md-12 eText">Series</div>
            <div class="col-lg-12 col-md-12 eText name">金致焕肌系列</div>
            <div class="col-lg-12 col-md-12 eText price"><span>￥</span>1099</div>
            <div class="col-lg-12 col-md-12">
                <div class="checkD"><a href="/product/33" target="_blank">查看详情</a></div>
            </div>
            <div class="imgBox">
                <img class="goldImg" src="/images/web/gold.png" alt="">
                <div class="col-lg-12 col-md-12 maxText">奢华能量，紧致提拉塑颜</div>
                <div class="col-lg-12 col-md-12 minText">隐退岁月年轮，重唤年轻动力</div>
            </div>
        </div>--}}{{--
    </div>--}}
</div>
<div class="container-fluid wakeLine"></div>
<div class="container-fluid goldCon water">
    <a href="/product/34" target="_blank">
        <img src="/images/web/water1.png" alt="">
    </a>
    {{--<div class="container">
        --}}{{--<div class="textBox">
            <div class="col-lg-12 col-md-12 eText">Moisturizing</div>
            <div class="col-lg-12 col-md-12 eText">Hydrating</div>
            <div class="col-lg-12 col-md-12 eText">Series</div>
            <div class="col-lg-12 col-md-12 eText name">水嫩保湿系列</div>
            <div class="col-lg-12 col-md-12 eText price"><span>￥</span>618</div>
            <div class="col-lg-12 col-md-12">
                <div class="checkD"><a href="/product/34" target="_blank">查看详情</a></div>
            </div>
            <div class="imgBox">
                <img class="goldImg" src="/images/web/water.png" alt="">
                <div class="col-lg-12 col-md-12 maxText">深补水，莹润透亮</div>
                <div class="col-lg-12 col-md-12 minText">唤醒肌肤，深层莹润，水与白不可或缺。</div>
            </div>
        </div>--}}{{--
    </div>--}}
</div>
<div class="container-fluid qidian">
    <a href="/product/39" target="_blank">
        <img src="/images/web/qidian1.png" alt="">
    </a>
    {{--<div class="qidianText">
        <div class="col-lg-12 col-md-12 eText">Beauty</div>
        <div class="col-lg-12 col-md-12 eText">Filter Cushion</div>
        <div class="col-lg-12 col-md-12 eText">Cream</div>
        <div class="col-lg-12 col-md-12 eText name">美肌滤镜气垫霜</div>
        <div class="col-lg-12 col-md-12 eText price"><span>￥</span>198</div>
        <div class="col-lg-12 col-md-12">
            <div class="checkD"><a href="/product/39" target="_blank">查看详情</a></div>
        </div>
    </div>--}}
</div>
<div class="container qidian fendi">
    <a href="/product/37" target="_blank">
        <img src="/images/web/fendi1.png" alt="">
    </a>
    {{--<div class="qidianText">
        <div class="col-lg-12 col-md-12 eText">Beauty</div>
        <div class="col-lg-12 col-md-12 eText">Filter Cushion</div>
        <div class="col-lg-12 col-md-12 eText">Cream</div>
        <div class="col-lg-12 col-md-12 eText name">美肌滤镜精华粉底液</div>
        <div class="col-lg-12 col-md-12 eText price"><span>￥</span>268</div>
        <div class="col-lg-12 col-md-12">
            <div class="checkD"><a href="/product/37" target="_blank">查看详情</a></div>
        </div>
    </div>--}}
</div>
@include("home.navBottom")
<script src="/js/jquery-3.2.1.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script src="/js/swiper.min.js"></script>
<script>
	var swiper = new Swiper('.swiper-container', {
      autoplay: {
        delay: 5000,
        stopOnLastSlide: false,
        disableOnInteraction: true,
      },
      spaceBetween: 30,
      effect: 'fade',
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
      },
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
	});
	$(document).ready(function () {
      /*----------大导航下效果----------------*/
      $('.navbContent li a').on('mouseenter',function () {
      	$('.navbContent li a .ink').removeClass('animates')
        $(this).children('.ink').addClass('animates')
      })
      $('.navbContent li').on('click',function () {
      	if($(this).hasClass('active')){
          $(this).children().css('background','rgba(200,173,126,0.8)')
        }else{
          $(this).children().css('background','none')
        }
      })
      $('.navbContent ul').on('mouseleave',function () {
	      $('.navbContent li a .ink').removeClass('animates')
      })
      /*-0---------小导航效果-------------*/
      $('.minTab .tabList').on('mouseenter',function () {
        const index=$(this).index() + 1
        $('.minTab .tabList .con .bg').removeClass('active')
        $(this).children('.con').children('.bg').addClass('active')
        $('.minCon .conList').fadeOut(100)
        $('.minCon .conList:nth-child('+index+')').fadeIn(200)
      })
      $('.minCon .cons .bg').on('mouseenter',function () {
//       	console.log(1111)
      	$(this).css('background','#fff')
        $(this).parent().siblings().children('.bg').css('background','#D6D6D6')
      })
      $('.minCon .conList').mouseleave(function () {
        $('.minCon .cons .bg').css('background','#fff')
      })
      /* 搜索 */
      $('#searchButton').click(function(){
		var text = $("#seachText").val();
		if(text && text.length > 0) {
			window.location.href="/product/index?seachText=" + text;
		}
      });
	})
</script>
@yield('js')
</body>
</html>
