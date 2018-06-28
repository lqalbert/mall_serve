@extends('home.base', ['bar' => $bar])

@section('css')
    <link rel="stylesheet" href="/css/home/product/index.css"/>
@endsection

@section('nav')
@include("home.nav",['bar' => $bar])
@endsection


@section('content')
    <div id="product" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 productContent">
        <div class="productTitle col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <a href="{{URL('/')}}">首页</a> >
            <a href="{{URL('product/index')}}">全部产品</a> >
            <a href="#">{{$name}}</a>
        </div>
        <div class="productBar col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pls">
                {{--<div class="btnBox col-lg-3 col-md-3 col-sm-4 col-xs-6">
                    <a href="{{URL('product/index?type=all')}}">
                        <div class="{{$type['all']}} col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            全部
                        </div>
                    </a>
                </div>--}}
                <div class="btnBox col-lg-3 col-md-3 col-sm-4 col-xs-6">
                    <a href="{{ route('product/index', ['label'=>'面膜'])  }}">
<!--                     {{--$type['new']--}} -->
                        <div class=" col-lg-12 col-md-12 col-sm-12 col-xs-12 {{$type['面膜']}}">
                            护肤
                        </div>
                    </a>
                </div>
                <div class="btnBox col-lg-3 col-md-3 col-sm-4 col-xs-6">
                    <a href="{{ route('product/index', ['label'=>'彩妆'])  }}">
                        <div class=" col-lg-12 col-md-12 col-sm-12 col-xs-12 {{$type['彩妆']}}">
                            彩妆
                        </div>
                    </a>
                </div>
                <div class="btnBox col-lg-3 col-md-3 col-sm-4 col-xs-6">
                    <a href="{{ route('product/index', ['label'=>'焕肤紧致系列'])  }}">
                        <div class=" col-lg-12 col-md-12 col-sm-12 col-xs-12 {{$type['焕肤紧致系列']}}">
                            焕肤紧致系列
                        </div>
                    </a>
                </div>
                <div class="btnBox col-lg-3 col-md-3 col-sm-4 col-xs-6">
                    <a href="{{ route('product/index', ['label'=>'青春凝时冻龄系列'])  }}">
                        <div class=" col-lg-12 col-md-12 col-sm-12 col-xs-12 青春凝时冻龄系列">
                            青春凝时冻龄系列
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="productLists col-lg-12 col-md-12 col-sm-12 col-xs-12">
            @forelse ($goods as $item)
            <a href="{{URL('product', ['id'=>$item->id])}}">
                <div class="productBox col-lg-3 col-md-3 col-sm-4 col-xs-12">
                    <div class="productList col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <img src="{{$item->cover_url}}" alt="">
                        <div class="msgPro col-lg-12 col-md-12 col-sm-12 col-xs12">
                            <div class="title col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                {{$item->goods_name}}
                            </div>
                            <div class="price col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <span>￥{{$item->getPrice()}}</span>
<!--                                 <span class="high">￥{{$item->del_price}}</span> -->
                                @if($item->new_goods == 1)
                                <span class="hot">热卖</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            @empty
            <p style="text-align: center; padding: 20px 0px;"> 新款待上线，敬请关注</p>
            @endforelse 
        </div>
        
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function () {
        	let hei=parseInt($('#product .productLists').css('height'));
            if(hei<=100){
            	$('.navBottom').css('position','absolute');
	            $('.navBottom').css('width','100%');
	            $('.navBottom').css('left','50%');
	            $('.navBottom').css('bottom','0');
	            $('.navBottom').css('transform','translate(-50%, 0)');
            }
        })
    </script>
@endsection
