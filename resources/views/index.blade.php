<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name', '商城') }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <link rel="shortcut icon" href="/32.ico" />
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/swiper.min.css"/>
    <link rel="stylesheet" href="css/home/index/index.css"/>
    <link rel="stylesheet" href="css/home/index/iconfonts.css"/>
</head>
<body>
<!--导航-->
@include("home.nav")
<!--/ 导航-->

<div id="banner" class="indexContent container-fluid">
    <div class=" bannerBox col-lg-12 col-md-12 col-sm-12 col-xs-12" style="height: 100%;padding: 0">
        <div class="swiper-container2" style="width: 100%;height: 100%">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <a href="{{ url('/product/20')  }}">
                        <img class="imgs" src="images/home/index/minBanner.gif" alt="">
                    </a>
                </div>
                <div class="swiper-slide">
                    <a href="{{ url('/product/34')  }}">
                        <img class="imgs" src="images/home/index/minBanner0.jpg" alt="">
                    </a>
                </div>
                <div class="swiper-slide">
                    <a href="{{ url('/product/27')  }}">
                        <img class="imgs" src="images/home/index/minBanner1.jpg" alt="">
                    </a>
                </div>
                <div class="swiper-slide">
                    <a href="{{ url('/product/6')  }}">
                        <img class="imgs" src="images/home/index/minBanner2.jpg" alt="">
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="paginationBox col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="col-lg-8 col-lg-offset-2 col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1 col-xs-12 bbx">
        </div>
    </div>
</div>

<div class="container ">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 proTab">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-12">
                <div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-10 col-sm-offset-1 col-xs-12">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <span class="proAction activeSpan">重磅新品</span>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <span class="proAction">口碑之选</span>
                    </div>
                    {{--<div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
                        <span class="proAction">爆款系列</span>
                    </div>--}}
                </div>
            </div>
        </div>
        {{--产品列表--}}
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding: 0">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 indexPro indexSaleL" style="padding: 0">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 indexBox">
                    <div class="swiper-container swiper-container1" style="width: 100%">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <a href="{{ url('/product/6') }}">
                                    <div class="indexList">
                                        <img src="images/home/index/new1.jpg" alt="">
                                        <div class="title">
                                            <span>美肌滤镜水精华粉底液</span>
                                        </div>
                                        <div class="describe">
                                            <span>一滴入底 缔造无暇丝缎肌</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="swiper-slide">
                                <a href="{{ url('/product/6') }}">
                                    <div class="indexList">
                                        <img src="images/home/index/new2.jpg" alt="">
                                        <div class="title">
                                            <span>美肌滤镜气垫霜</span>
                                        </div>
                                        <div class="describe">
                                            <span>打造女神透光感肌</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="swiper-slide">
                                <a href="{{ url('/product/32') }}">
                                    <div class="indexList">
                                        <img src="images/home/index/new3.jpg" alt="">
                                        <div class="title">
                                            <span>水嫩保湿水</span>
                                        </div>
                                        <div class="describe">
                                            <span>打造水润鲜肌</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="swiper-slide">
                                <a href="{{ url('/product/29') }}">
                                    <div class="indexList">
                                        <img src="images/home/index/new4.jpg" alt="">
                                        <div class="title">
                                            <span>水嫩保湿精华液</span>
                                        </div>
                                        <div class="describe">
                                            <span>水力充盈 就是玻尿酸</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <!-- Add Arrows -->
                        <!-- Add Pagination -->
                        <div class="swiper-pagination1"></div>
                    </div>
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 indexPro indexNew" style="padding: 0">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 indexBox">
                    <div class="swiper-container swiper-container3" style="width: 100%">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <a href="{{ url('/product/21') }}">
                                    <div class="indexList">
                                        <img src="images/home/index/sel1.jpg" alt="">
                                        <div class="title">
                                            <span>vc匀净面面膜</span>
                                        </div>
                                        <div class="describe">
                                            <span>匀净透光 光耀精华</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="swiper-slide">
                                <a href="{{ url('/product/22') }}">
                                    <div class="indexList">
                                        <img src="images/home/index/sel2.jpg" alt="">
                                        <div class="title">
                                            <span>蓝铜胜肽水光面膜</span>
                                        </div>
                                        <div class="describe">
                                            <span>密集保湿</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="swiper-slide">
                                <a href="{{ url('/product/27') }}">
                                    <div class="indexList">
                                        <img src="images/home/index/sel3.jpg" alt="">
                                        <div class="title">
                                            <span>金致焕肌修护精华液</span>
                                        </div>
                                        <div class="describe">
                                            <span>一瓶多效 奢养肌底</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="swiper-slide">
                                <a href="{{ url('/product/28') }}">
                                    <div class="indexList">
                                        <img src="images/home/index/sel4.jpg" alt="">
                                        <div class="title">
                                            <span>水嫩洁面乳</span>
                                        </div>
                                        <div class="describe">
                                            <span>一瓶多效 奢养肌底</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <!-- Add Arrows -->
                        <!-- Add Pagination -->
                        <div class="swiper-pagination3"></div>
                    </div>
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid" style="padding: 0;">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 goldSuit" style="margin-bottom: 35px">
        <a href="{{ url('/product/6') }}">
            <img src="images/home/index/maxBanner0.jpg" alt="">
        </a>
    </div>
</div>
<div class="container">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 indexSale">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 saleImg">
            <img src="images/home/index/pro1.jpg" alt="">
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 saleCont">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 box">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 title">
                    深层清洁&nbsp;开启净透肌肤
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 describe">
                        <span>
                            水嫩保湿洁面乳 100g
                        </span>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="checkout">
                        <a href="{{ url('/product/28') }}">
                            查看详情
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 indexSale">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 saleCont saleConts">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 box">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 title">
                    洁净奢养&nbsp;重塑年轻源动力
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 describe">
                        <span>
                            金致焕肌洁颜乳 100g
                        </span>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="checkout">
                        <a href="{{ url('/product/23') }}">
                            查看详情
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 saleImg saleImgs">
            <img src="images/home/index/pro2.jpg" alt="">
        </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 indexSale">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 saleImg">
            <img src="images/home/index/pro3.jpg" alt="">
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 saleCont">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 box">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 title">
                    蓝铜胜肽&nbsp;绽现年轻水润肌
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 describe">
                        <span>
                            蓝铜胜肽水光面膜 26mlx5片
                        </span>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="checkout">
                        <a href="{{ url('/product/22') }}">
                            查看详情
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 indexSale">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 saleCont saleConts">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 box">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 title">
                    烟酰胺&nbsp;&nbsp;透光焕亮VC面膜
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 describe">
                        <span>
                            VC匀净面膜 26mlx5片
                        </span>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="checkout">
                        <a href="{{ url('/product/21') }}">
                            查看详情
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 saleImg saleImgs">
            <img src="images/home/index/pro4.jpg" alt="">
        </div>
    </div>
</div>
<div class="container-fluid" style="padding: 0;">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 goldSuit" style="margin-top: 35px">
        <a href="{{ url('/product/33') }}">
            <img src="images/home/index/maxBanner.jpg" alt="">
        </a>
    </div>
</div>
@include("home.sidetool")
@include("home.navBottom")


<script src="js/jquery-3.2.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/swiper.min.js"></script>
<script>
	$(document).ready(function () {
		var flag = true;
		function IsPC() {
			var userAgentInfo = navigator.userAgent;
			var Agents = ["Android", "iPhone",
				"SymbianOS", "Windows Phone"];
			for (var v = 0; v < Agents.length; v++) {
				if (userAgentInfo.indexOf(Agents[v]) > 0) {
					flag = false;
					break;
				}
			}
		}
		var num=5;
		IsPC();
		if(!flag){
			num=1
		}
		/*----轮播插件----*/
		let text=['夏日美肌 以黑净肤','夏日福利 水嫩保湿','修护奢宠 金致焕肌','美肌滤镜 轻妆上阵'];
		let mySwiper=new Swiper('#banner .swiper-container2',{
			direction:'horizontal',
			loop:true,
			//分页器
			pagination: {
				el: '.bbx',
				clickable: true,
				renderBullet: function (index, className) {
					return '<div class="col-lg-3 col-md-3 col-sm-4 col-xs-6 ' + className + '">' + text[index] + '</div>';
				},
			},
			autoplay:{
				delay:5000,
				stopOnLastSlide:false,
				disableOnInteraction:true
			}
		});
		let swiper = new Swiper('.swiper-container1', {
			slidesPerView: 4,
			spaceBetween: 20,
			navigation: {
				nextEl: '.indexSaleL .swiper-button-next',
				prevEl: '.indexSaleL .swiper-button-prev',
			},
			pagination: {
				el: '.swiper-pagination1',
				clickable: true,
			},
			observer:true,
			observeParents:true
		});
		let swiper3 = new Swiper('.swiper-container3', {
			slidesPerView: 4,
			spaceBetween: 20,
			navigation: {
				nextEl: '.indexNew .swiper-button-next',
				prevEl: '.indexNew .swiper-button-prev',
			},
			pagination: {
				el: '.swiper-pagination3',
				clickable: true,
			},
			observer:true,
			observeParents:true
		});
		let swiper4 = new Swiper('.swiper-container4', {
			slidesPerView: 4,
			spaceBetween: 20,
			navigation: {
				nextEl: '.indexHot .swiper-button-next',
				prevEl: '.indexHot .swiper-button-prev',
			},
			pagination: {
				el: '.swiper-pagination4',
				clickable: true,
			},
			observer:true,
			observeParents:true
		});
		/*----------产品切换效果---------*/
		$('.proTab .proAction').on('click',function () {
			let num=$(this).parent().index();
			$('.proTab .proAction').removeClass('activeSpan');
			$(this).addClass('activeSpan');
			$('.indexPro').hide();
			$('.indexPro:eq('+num+')').show();
		});
		/*---------------*/
		var flg=true
		/*$('#navBut').on('touchend',function () {
            $('#ul li a').addClass('navC')
        })
        $('#ul li a').on('click',function () {
            $('#ul li a').removeClass('sta')
            $(this).addClass('sta')
        })*/
		/*---------------菜单鼠标事件*/
		$('#ul li a').hover(function () {
			$('#ul li a div').removeClass('line')
			$(this).children('div').addClass('line')
		});
		$('#ul').mouseleave(function () {
			var flg=true;
			$('#ul li a').each(function () {
				if($(this).hasClass('sta')){
					$('#ul li a div').removeClass('line')
					$(this).children('div').addClass('line')
					flg=false
				}
			});
			if(flg){
				$('#ul li a div').removeClass('line')
			}
		});
		$('#goTo').click(function () {
			window.location.href="{{URL('car/index')}}"
		});
		$('.buyList .del').click(function () {
			flg=false
		});
		$(document.body).click(function (e) {
			var ee=e.srcElement?e.srcElement:e.target;
			if(ee.id!='countP'){
				$('#myCenter').fadeOut(10)
			}
			if(ee.id!='buyC'&&flg){
				$('#buyCar').fadeOut(10)
			}
		});
		//监听滚动条
		/*$(window).scroll(function () {
			var top=$(document).scrollTop();
			if(top>=200){
				$('.personBar').fadeOut('slow');
			}else{
				$('.personBar').fadeIn('fast')
			}
		});*/
		$('#scrollTop').on('click',function () {
			$(document).scrollTop(0);
		});
		//搜索点击事件
		$('#souI').click(function(event) {
			var seachText = $('#searchB').val();
			if(seachText){
				window.location.href="{{URL('product/index?seachText=')}}"+seachText;
			}
		});
	})
</script>
</body>
</html>
