@extends('home.base')
@section('css')
    <link rel="stylesheet" href="/css/home/product/product.css"/>
@endsection

@section('nav')
@include("home.nav",['bar' => $bar])
@endsection

@section('content')
    <div class="container">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 productBar">
            <div class="lle">
                <a style="color: #333" href="/">首页</a>&nbsp;<span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>&nbsp;
                <a style="color: #666" href="{{ url('product/index') }}">全部产品</a>&nbsp;
                <span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>&nbsp;
                @foreach($goods->category as $cat)
                    @if($loop->last)
                        <span style="color: #C3A46F">{{$cat->label}}</span>
                    @else
                        <a style="color: #666" href="{{ url('product/index') }}">{{$cat->label}}</a>&nbsp;
                        <span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>&nbsp;
                    @endif
                @endforeach
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 productInfo">
            <div class="col-lg-5 col-md-5 col-sm-6 col-xs-12 proLef">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 view">
                    <div class="swiper-container first">
                        <a href="#" class="arrow-left"></a>
                        <a href="#" class="arrow-right"></a>
                        <div class="swiper-wrapper">
                            @foreach($goods->imgs as $img)
                                <div class="swiper-slide">
                                    <img src="{{$img->url}}" alt="">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="preview col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <a href="#" class="arrow-left"></a>
                    <a href="#" class="arrow-right"></a>
                    <div class="swiper-container second">
                        <div class="swiper-wrapper">
                            @foreach($goods->imgs as $img)
                                <div class="swiper-slide @if ($loop->first)
                                        active-nav
@endif">
                                    <img src="{{$img->url}}" alt="">
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 col-md-7 col-sm-6 col-xs-12 proRig">
                <div class="proRigBox col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 rigTit">
                        {{$goods->goods_name}}
                        
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 titDec">
                        {{$goods->subtitle}}
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 proType">产品系列</div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 proCon">
                    
                    @foreach($goods->category as $cat)
                        {{$cat->label}}
                        @break
                    @endforeach
                        
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 proType">产品功效</div>
                    <div class="col-lg-12 col-md-12 xol-sm-12 col-xs-12 proCon">
                        {{$goods->brief}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 productContent">
        <div class="container">
            <div class="contentLeft col-lg-3 col-md-4 col-sm-5 col-xs-12">
                <div class="title col-lg-12 col-md-12 col-sm-12 col-xs-12">相关推荐</div>
                @foreach($recoms as $reItem)
                    <a href="{{URL('product', ['id'=>$reItem->id])}}">
                        <div class="lists col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="listBox col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="imgs col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <img src="{{$reItem->cover_url}}" alt="">
                                </div>
                                <div class="listName col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    {{$reItem->goods_name}}
                                </div>
                                <div class="listPrice col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <span class="price">￥{{$reItem->getPrice()}}</span>
                                    </div>
                                    <div class="volum col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <span class="glyphicon glyphicon-heart-empty" aria-hidden="true"></span>
                                        {{$reItem->sale_count}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="contentRight col-lg-9 col-md-8 col-sm-7 col-xs-12">
                <div style="padding: 0" class="contentDetail col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    {!! $goods->description !!}
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