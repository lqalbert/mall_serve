@extends('home.base')
@section('css')
    <link rel="stylesheet" href="/css/home/product/product.css"/>
@endsection
@section('content')
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 productBar">
        <div class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1 col-sm-12 col-xs-12 lle">
            <div class=" col-lg-10 col-lg-offset-1 col-md-12 col-sm-12 col-xs-12 lle">
                <a style="color: #333" href="/">首页</a>&nbsp;<span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>&nbsp;
                <a style="color: #666" href="{{ url('product/index') }}">全部产品</a>&nbsp;<span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>&nbsp;
                    <a style="color: #666" href="{{ url('product/index') }}">青春系列</a>&nbsp;<span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>&nbsp;
                <span style="color: #C3A46F">护肤品套装面部护理保湿锁水爽肤水保湿霜乳液化妆品套装</span>
            </div>
        </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 productInfo">
        <div class="col-lg-10 col-lg-offset-1 col-md-12 col-sm-12 col-xs-12 lle lel">
            <div class="col-lg-10 col-lg-offset-1 col-md-12 col-sm-12 col-xs-12 lle">
                <div class="col-lg-5 col-md-5 col-sm-6 col-xs-12 proLef">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 view">
                        <div class="swiper-container first">
                            <a href="#" class="arrow-left"></a>
                            <a href="#" class="arrow-right"></a>
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <img src="/storage/goods/1.png" alt="">
                                </div>
                                <div class="swiper-slide">
                                    <img src="/storage/goods/2.png" alt="">
                                </div>
                                <div class="swiper-slide">
                                    <img src="/storage/goods/3.png" alt="">
                                </div>
                                <div class="swiper-slide">
                                    <img src="/storage/goods/4.png" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="preview col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <a href="#" class="arrow-left"></a>
                        <a href="#" class="arrow-right"></a>
                        <div class="swiper-container second">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide active-nav">
                                    <img src="/storage/goods/1.png" alt="">
                                </div>
                                <div class="swiper-slide">
                                    <img src="/storage/goods/2.png" alt="">
                                </div>
                                <div class="swiper-slide">
                                    <img src="/storage/goods/3.png" alt="">
                                </div>
                                <div class="swiper-slide">
                                    <img src="/storage/goods/4.png" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 top">
                        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 topLef"><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span></div>
                        <div id="maxImg" class="col-lg-10 col-md-10 col-sm-10 col-xs-10 topImg">
                            <img src="__ROOT__/static/images/home/product/product.jpg" style="width: 100%" alt="">
                        </div>
                        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 topRig"><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 bot">
                        <div id="minImg" class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-10 col-xs-offset-1">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-5 botI">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 imgB sta"></div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-5 botI">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 imgB"></div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-5 botI">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 imgB"></div>
                            </div>
                        </div>
                    </div>-->
                </div>
                <div class="col-lg-7 col-md-7 col-sm-6 col-xs-12 proRig">
                    <div class="proRigBox col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 rigTit">
                            护肤品套装面部护理保湿锁水爽肤水保湿霜乳液化妆品套装
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 rigPrice">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="left col-lg-6 col-md-6 col-sm-4 col-xs-4">
                                    原价： <span class="llPrice">￥399.00</span>
                                </div>
                                <div class="right col-lg-6 col-md-6 col-sm-8 col-xs-8">
                                    评价：5655 累积销量：1254
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                促销价： <span class="nowPrice">￥99.00</span><span class="nowMsg">新品限时促销</span>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                优惠券： <span class="lowTickets">新人立减10元</span>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 colorBoxs">
                            <span>颜色：</span>
                            <div class="colorBox"></div>
                            <div class="colorBox"></div>
                            <div class="colorBox"></div>
                            <div class="colorBox"></div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 spec">
                            <div>规格：</div>
                            <div class="specNum">
                                5件套
                                <div class="cls">
                                    <span class="glyphicon glyphicon-ok " aria-hidden="true"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 rigNum">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 left">
                                <div class="lefN">
                                    数量：
                                </div>
                                <div class="middleN">
                                    <input id="productNumber" type="number" class="productNumber" value="0">
                                    <div id="increase" class="increase">-</div>
                                    <div id="decrease" class="decrease">+</div>
                                </div>
                                <div class="repertory">库存：5562件</div>
                            </div>
                        </div>
                        <div class="shareBox col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="share">1512</div>
                            <div class="share">分享</div>
                        </div>
                        {{--<div class="buyBox col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="col-lg-4 col-md-4 col-sm-5 col-xs-6">
                                <div class="add buyNow col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    立即购买
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-5 col-xs-6">
                                <div class="add col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    加入购物车
                                </div>
                            </div>
                        </div>--}}
                        <div class="serviceBox col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div>服务承诺：</div>
                        </div>
                        <div class="payBox col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            支付方式：
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 productContent">
        <div class="lle col-lg-10 col-lg-offset-1 col-md-12 col-sm-12 col-xs-12">
            <div class="col-lg-10 col-lg-offset-1 col-md-12 col-sm-12 col-xs-12 lls">
                <div class="contentLeft col-lg-3 col-md-4 col-sm-5 col-xs-12">
                    <div class="title col-lg-12 col-md-12 col-sm-12 col-xs-12">相关推荐</div>
                    <a href="{{URL('product/product')}}">
                        <div class="lists col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="listBox col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="imgs col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <img src="/images/home/product/recommend1.png" alt="">
                                </div>
                                <div class="listName col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    巨补水明星豪华6件大餐！收缩毛孔婴儿肌
                                </div>
                                <div class="listPrice col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <span class="price">￥99.00</span>
                                    </div>
                                    <div class="volum col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <span class="glyphicon glyphicon-heart-empty" aria-hidden="true"></span>
                                        36
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                    <a href="{{URL('product/product')}}">
                        <div class="lists col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="listBox col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="imgs col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <img src="/images/home/product/recommend2.png" alt="">
                                </div>
                                <div class="listName col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    巨补水明星豪华6件大餐！收缩毛孔婴儿肌
                                </div>
                                <div class="listPrice col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <span class="price">￥99.00</span>
                                    </div>
                                    <div class="volum col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <span class="glyphicon glyphicon-heart-empty" aria-hidden="true"></span>
                                        36
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                    <a href="{{URL('product/product')}}">
                        <div class="lists col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="listBox col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="imgs col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <img src="/images/home/product/recommend3.png" alt="">
                                </div>
                                <div class="listName col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    巨补水明星豪华6件大餐！收缩毛孔婴儿肌
                                </div>
                                <div class="listPrice col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <span class="price">￥99.00</span>
                                    </div>
                                    <div class="volum col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <span class="glyphicon glyphicon-heart-empty" aria-hidden="true"></span>
                                        36
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                    <a href="{{URL('product/product')}}">
                        <div class="lists col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="listBox col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="imgs col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <img src="/images/home/product/recommend4.png" alt="">
                                </div>
                                <div class="listName col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    巨补水明星豪华6件大餐！收缩毛孔婴儿肌
                                </div>
                                <div class="listPrice col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <span class="price">￥99.00</span>
                                    </div>
                                    <div class="volum col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <span class="glyphicon glyphicon-heart-empty" aria-hidden="true"></span>
                                        36
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                    <a href="{{URL('product/product')}}">
                        <div class="lists col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="listBox col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="imgs col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <img src="/images/home/product/recommend5.png" alt="">
                                </div>
                                <div class="listName col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    巨补水明星豪华6件大餐！收缩毛孔婴儿肌
                                </div>
                                <div class="listPrice col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <span class="price">￥99.00</span>
                                    </div>
                                    <div class="volum col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <span class="glyphicon glyphicon-heart-empty" aria-hidden="true"></span>
                                        36
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                    <a href="{{URL('product/product')}}">
                        <div class="lists col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="listBox col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="imgs col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <img src="/images/home/product/recommend6.png" alt="">
                                </div>
                                <div class="listName col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    巨补水明星豪华6件大餐！收缩毛孔婴儿肌
                                </div>
                                <div class="listPrice col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <span class="price">￥99.00</span>
                                    </div>
                                    <div class="volum col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <span class="glyphicon glyphicon-heart-empty" aria-hidden="true"></span>
                                        36
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="contentRight col-lg-9 col-md-8 col-sm-7 col-xs-12">
                    <div class="title col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="tabs actives">
                            商品详情
                            <div class="line"></div>
                        </div>
                        <div class="tabs">
                            累积评价
                            <span class="num">1825</span>
                        </div>
                    </div>
                    <div class="contentDetail col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="imgBox col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <img src="/images/home/product/detail1.png" alt="">
                        </div>
                        <div class="imgBox col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <img src="/images/home/product/detail2.png" alt="">
                        </div>
                        <div class="imgBox col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <img src="/images/home/product/detail3.png" alt="">
                        </div>
                        <div class="imgBox col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <img src="/images/home/product/detail4.png" alt="">
                        </div>
                        <div class="imgBox col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <img src="/images/home/product/detail5.png" alt="">
                        </div>
                        <div class="imgBox col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <img src="/images/home/product/detail6.png" alt="">
                        </div>
                        <div class="imgBox col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <img src="/images/home/product/detail7.png" alt="">
                        </div>
                        <div class="imgBox col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <img src="/images/home/product/detail8.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function () {
            $('#increase').on('click',function () {
                var num=$('#productNumber').val()
                if(num>0){
                    num-=1
                    $('#productNumber').val(num)
                }
            });
            $('#decrease').on('click',function () {
                var num=parseInt($('#productNumber').val())
                if(isNaN(num)){
                    num=0
                }
                $('#productNumber').val(num+=1)
            });
            var viewSwiper = new Swiper('.view .swiper-container', {
                on:{
                    slideChangeTransitionStart: function() {
                        updateNavPosition()
                    }
                }
            });

            $('.view .arrow-left,.preview .arrow-left').on('click', function(e) {
                e.preventDefault();
                if (viewSwiper.activeIndex == 0) {
                    viewSwiper.slideTo(viewSwiper.slides.length - 1, 1000);
                    return
                }
                viewSwiper.slidePrev()
            });
            $('.view .arrow-right,.preview .arrow-right').on('click', function(e) {
                e.preventDefault();
                if (viewSwiper.activeIndex == viewSwiper.slides.length - 1) {
                    viewSwiper.slideTo(0, 1000);
                    return
                }
                viewSwiper.slideNext()
            });

            var previewSwiper = new Swiper('.preview .swiper-container', {
                //visibilityFullFit: true,
                slidesPerView: 'auto',
                allowTouchMove: false,
                on:{
                    tap: function() {
                        viewSwiper.slideTo(previewSwiper.clickedIndex)
                    }
                }
            });

            function updateNavPosition() {
                $('.preview .active-nav').removeClass('active-nav');
                var activeNav = $('.preview .swiper-slide').eq(viewSwiper.activeIndex).addClass('active-nav');
                if (!activeNav.hasClass('swiper-slide-visible')) {
                    if (activeNav.index() > previewSwiper.activeIndex) {
                        var thumbsPerNav = Math.floor(previewSwiper.width / activeNav.width()) - 1;
                        previewSwiper.slideTo(activeNav.index() - thumbsPerNav)
                    } else {
                        previewSwiper.slideTo(activeNav.index())
                    }
                }
            }

        })
    </script>
@endsection