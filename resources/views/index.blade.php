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
                @if (isset($topImg))
                    @foreach ($topImg as $img)
                        <div class="swiper-slide">
                            <a href="{{ url($img->href_url) }}">
                                <img class="imgs" src="{{ asset($img->cover_url) }}" alt="{{$img->name}}">
                            </a>
                        </div>
                    @endforeach
                @endif
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
                </div>
            </div>
        </div>
        {{--产品列表--}}
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding: 0">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 indexPro indexSaleL" style="padding: 0">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 indexBox">
                    <div class="swiper-container swiper-container1" style="width: 100%">
                        <div class="swiper-wrapper">
                            @if (isset($importantGoods))
                                @foreach ($importantGoods as $goods)
                                    <div class="swiper-slide">
                                        <a href="{{ url(empty($goods->href_url) ? '#' : $goods->href_url) }}" style="color: #333;text-decoration: none;">
                                            <div class="indexList">
                                                <img src="{{ asset($goods->cover_url) }}" alt="{{$goods->name}}">
                                                <div class="title">
                                                    <span>{{ $goods->name }}</span>
                                                </div>
                                                <div class="describe">
                                                    <span>{{ $goods->description }}</span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            @endif
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
                            @if (isset($goodGoods))
                                @foreach ($goodGoods as $goods)
                                    <div class="swiper-slide">
                                        <a href="{{ url(empty($goods->href_url) ? '#' : $goods->href_url) }}">
                                            <div class="indexList">
                                                <img src="{{ asset($goods->cover_url) }}" alt="{{$goods->name}}">
                                                <div class="title">
                                                    <span>{{ $goods->name }}</span>
                                                </div>
                                                <div class="describe">
                                                    <span>{{ $goods->description }}</span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            @endif
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
        @if (isset($showMid))
            <div class="swiper-slide">
                <a href="{{ url($showMid->href_url) }}">
                    <img src="{{ asset($showMid->cover_url) }}" alt="{{$showMid->name}}">
                </a>
            </div>
        @endif
    </div>
</div>
<div class="container">
    @if (isset($imgText))
        @foreach ($imgText as $goods)
            @if ($loop->index % 2 == 0)
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 indexSale">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 saleImg">
                        <img src="{{ asset($goods->cover_url) }}" alt="{{$goods->name}}">
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 saleCont">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 box">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 title">
                                {{ $goods->name }}
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 describe">
                                <span>
                                    {{ $goods->description }}
                                </span>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <a href="{{ url($goods->href_url) }}">
                                    <div class="checkout">查看详情</div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 indexSale">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 saleCont saleConts">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 box">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 title">
                                {{ $goods->name }}
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 describe">
                                <span>
                                    {{ $goods->description }}
                                </span>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <a href="{{ url($goods->href_url) }}">
                                    <div class="checkout">查看详情</div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 saleImg saleImgs">
                        <img src="{{ asset($goods->cover_url) }}" alt="{{$goods->name}}">
                    </div>
                </div>
            @endif
        @endforeach
    @endif

</div>
<div class="container-fluid" style="padding: 0;">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 goldSuit" style="margin-top: 35px">
        @if (isset($showBottom))
            <div class="swiper-slide">
                <a href="{{ url($showBottom->href_url) }}">
                    <img src="{{ asset($showBottom->cover_url) }}" alt="{{$showBottom->name}}">
                </a>
            </div>
        @endif
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
        let text = <?php echo json_encode($topName)?>;
        console.log(text);
        // let text=['夏日美肌 以黑净肤','夏日福利 水嫩保湿','修护奢宠 金致焕肌','美肌滤镜 轻妆上阵'];
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
