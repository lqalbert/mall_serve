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
                    <a href="{{ route('product/index', ['cate_id'=>'3'])  }}">
                        <img class="imgs" src="images/home/index/banner1.jpg" alt="">
                    </a>
                </div>
                <div class="swiper-slide">
                    <a href="{{ route('product/index', ['cate_id'=>'4'])  }}">
                        <img class="imgs" src="images/home/index/banner2.jpg" alt="">
                    </a>
                </div>
                <div class="swiper-slide">
                    <a href="{{ route('product/index', ['cate_id'=>'1'])  }}">
                        <img class="imgs" src="images/home/index/banner3.jpg" alt="">
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
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
                    <span class="proAction activeSpan">畅销单品</span>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
                    <span class="proAction">最新产品</span>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
                    <span class="proAction">爆款系列</span>
                </div>
            </div>
        </div>
        {{--产品列表--}}
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 indexSale" style="padding: 0">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 indexBox">
                <div class="swiper-container swiper-container1" style="width: 100%">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="indexList">
                                <img src="" alt="">
                                <div class="title">
                                    <span>VC匀净面膜</span>
                                </div>
                                <div class="describe">
                                    <span>美白舒缓 提亮肤色</span>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="indexList">
                                <img src="" alt="">
                                <div class="title">
                                    <span>净透焕颜黑面膜</span>
                                </div>
                                <div class="describe">
                                    <span>净透舒缓 细致润泽</span>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="indexList">
                                <img src="" alt="">
                                <div class="title">
                                    <span>蓝铜胜肽水光面膜</span>
                                </div>
                                <div class="describe">
                                    <span>莹亮水润 宛如新生</span>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="indexList">
                                <img src="" alt="">
                                <div class="title">
                                    <span>水嫩保湿水</span>
                                </div>
                                <div class="describe">
                                    <span>水嫩补水 唤醒活力</span>
                                </div>
                            </div>
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
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 indexNew" style="padding: 0">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 indexBox">
                <div class="swiper-container swiper-container3" style="width: 100%">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="indexList">
                                <img src="" alt="">
                                <div class="title">
                                    <span>金致焕肌洁颜乳</span>
                                </div>
                                <div class="describe">
                                    <span>洁净奢养 净肤养肤</span>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="indexList">
                                <img src="" alt="">
                                <div class="title">
                                    <span>金致焕肌精华乳</span>
                                </div>
                                <div class="describe">
                                    <span>奢华能量 紧致塑颜</span>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="indexList">
                                <img src="" alt="">
                                <div class="title">
                                    <span>金致焕肌精华水</span>
                                </div>
                                <div class="describe">
                                    <span>唤醒年轻态肌肤</span>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="indexList">
                                <img src="" alt="">
                                <div class="title">
                                    <span>金致焕肌修护精华液</span>
                                </div>
                                <div class="describe">
                                    <span>一瓶多效 奢养肌底</span>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="indexList">
                                <img src="" alt="">
                                <div class="title">
                                    <span>金致焕肌修护精华液</span>
                                </div>
                                <div class="describe">
                                    <span>一瓶多效 奢养肌底</span>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="indexList">
                                <img src="" alt="">
                                <div class="title">
                                    <span>金致焕肌修护精华液</span>
                                </div>
                                <div class="describe">
                                    <span>一瓶多效 奢养肌底</span>
                                </div>
                            </div>
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
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 indexHot" style="padding: 0">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 indexBox">
                <div class="swiper-container swiper-container4" style="width: 100%">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="indexList">
                                <img src="" alt="">
                                <div class="title">
                                    <span>水嫩保湿洁面乳</span>
                                </div>
                                <div class="describe">
                                    <span>温和亲肤 深透清洁</span>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="indexList">
                                <img src="" alt="">
                                <div class="title">
                                    <span>水嫩保湿精华液</span>
                                </div>
                                <div class="describe">
                                    <span>烟酰胺 邂逅润、透、白</span>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="indexList">
                                <img src="" alt="">
                                <div class="title">
                                    <span>水嫩保湿乳</span>
                                </div>
                                <div class="describe">
                                    <span>深入补水 清澈美肌</span>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="indexList">
                                <img src="" alt="">
                                <div class="title">
                                    <span>水嫩保湿水</span>
                                </div>
                                <div class="describe">
                                    <span>深入补水 光彩活力</span>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="indexList">
                                <img src="" alt="">
                                <div class="title">
                                    <span>水嫩保湿水</span>
                                </div>
                                <div class="describe">
                                    <span>深入补水 光彩活力</span>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="indexList">
                                <img src="" alt="">
                                <div class="title">
                                    <span>水嫩保湿水</span>
                                </div>
                                <div class="describe">
                                    <span>深入补水 光彩活力</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Add Arrows -->
                    <!-- Add Pagination -->
                    <div class="swiper-pagination4"></div>
                </div>
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </div>
</div>
<div class="container-fluid" style="padding: 0;">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 goldSuit">
        <img src="" alt="">
    </div>
</div>
<div class="container-fluid">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 facialMask">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 title">
            pulata面膜系列
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 facialList">
            <img src="" alt="">
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 facialList">
            <img src="" alt="">
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 facialList">
            <img src="" alt="">
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 facialList">
            <img src="" alt="">
        </div>
    </div>
</div>

<div class="container-fluid" style="padding: 0;">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 goldSuit">
        <img src="" alt="">
    </div>
</div>
<div class="container-fluid" style="padding: 0;">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 goldSuit">
        <img src="" alt="">
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
        let text=['夏日美肌 润泽透亮','夏日福利 水嫩保湿','洁净奢养 金致焕肌','时光流转 美是永恒'];
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
			    nextEl: '.indexSale .swiper-button-next',
			    prevEl: '.indexSale .swiper-button-prev',
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
            let con=$(this).text();
            $('.proTab .proAction').removeClass('activeSpan');
            $(this).addClass('activeSpan');
            if(con == "畅销单品"){
                $('.indexSale').show();
                $('.indexNew').hide();
                $('.indexHot').hide();
            }else if(con == '最新产品'){
	            $('.indexSale').hide();
	            $('.indexNew').show();
	            $('.indexHot').hide();
            }else{
	            $('.indexSale').hide();
	            $('.indexNew').hide();
	            $('.indexHot').show();
            }
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
        })
        $('#ul').mouseleave(function () {
            var flg=true
            $('#ul li a').each(function () {
                if($(this).hasClass('sta')){
                    $('#ul li a div').removeClass('line')
                    $(this).children('div').addClass('line')
                    flg=false
                }
            })
            if(flg){
                $('#ul li a div').removeClass('line')
            }
        })
        $('#buyC').click(function (e) {
            flg=true
            if($('#buyCar').css('display')=='none'){
                $('#buyCar').fadeIn(100);
                $('#myCenter').fadeOut(10)
            }else{
                $('#buyCar').fadeOut(10)
            }
        })
        $('#loginBar .countP').click(function (e) {
            if($('#myCenter').css('display')=='none'){
                $('#myCenter').fadeIn(100);
                $('#buyCar').fadeOut(10)
            }else{
                $('#myCenter').fadeOut(10)
            }
        })
        $('#goTo').click(function () {
            window.location.href="{{URL('car/index')}}"
        })
        $('.buyList .del').click(function () {
            flg=false
        })
        $(document.body).click(function (e) {
            var ee=e.srcElement?e.srcElement:e.target
            if(ee.id!='countP'){
                $('#myCenter').fadeOut(10)
            }
            if(ee.id!='buyC'&&flg){
                $('#buyCar').fadeOut(10)
            }
        });
        //监听滚动条
        $(window).scroll(function () {
            var top=$(document).scrollTop();
            if(top>=200){
                $('.personBar').fadeOut('slow');
            }else{
                $('.personBar').fadeIn('fast')
            }
        });
        $('#scrollTop').on('click',function () {
            $(document).scrollTop(0);
        })
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
