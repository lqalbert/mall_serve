@extends('home.base')
@section('css')
    <link rel="stylesheet" href="/css/home/sale/index.css"/>
@endsection

@section('nav')
@include("home.nav",['bar' => $bar])
@endsection

@section('content')
    <div id="saleBest" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="saleBestTitle col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <a href="{{URL('/')}}">首页</a>>
            <span>畅销榜单</span>
        </div>
        <div class="saleLists col-lg-12 col-md-12 col-sm-12 col-xs-12">
            @foreach($allGoods as $goods)

                <div class="saleList col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <a href="{{URL("product",['id'=>$goods->id])}}" title="{{$goods->goods_name}}">
                        <img class="mainImg" src="{{$goods->cover_url}}" alt="">
                        <div class="listTitle col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            {{$goods->goods_name}}&nbsp;
                            <span style="font-size: 14px;color: #666">{{$goods->specifications}}</span>
                        </div>
                        <div class="col-lg-12 col-md-12 col-xs-12 brief">
                            {{$goods->brief}}
                        </div>
                        <div class="listPrice col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <span class="price">￥{{$goods->getPrice()}}</span>
                            @if(!empty($goods->new_goods))
                                <span class="saleN">新品</span>
                            @endif
                            @if(!empty($goods->hot_goods))
                                <span class="saleN saleB">畅销</span>
                        @endif

                        <!--                                 <span class="shop"> -->
                            <!--                                 <img src="/images/home/sale/shopping.jpg" alt=""> -->
                            <!--                             	</span> -->
                        </div>
                    </a>
                </div>
        @endforeach
        <!--                     <div class="saleList col-lg-3 col-md-3 col-sm-6 col-xs-12"> -->
        <!--                         <a href="{{URL('product/product')}}"> -->
            <!--                             <img class="mainImg" src="/images/home/sale/cx.jpg" alt=""> -->
            <!--                             <div class="listTitle col-lg-12 col-md-12 col-sm-12 col-xs-12"> -->
            <!--                                 护肤品套装面部护理保湿锁水爽肤水保湿霜乳液化妆水 -->
            <!--                             </div> -->
            <!--                             <div class="listPrice col-lg-12 col-md-12 col-sm-12 col-xs-12"> -->
            <!--                                 <span class="price">￥119</span> -->
            <!--                                 <span class="saleN">新品</span> -->
            <!--                                 <span class="saleN saleB">畅销</span> -->
            <!--                                 <span class="shop"> -->
            <!--                                 <img src="/images/home/sale/shopping.jpg" alt=""> -->
            <!--                             </span> -->
            <!--                             </div> -->
            <!--                         </a> -->
            <!--                     </div> -->



        </div>
    </div>
@endsection
@section('js')
    <script>
      $(document).ready(function () {
	      $(document).ready(function () {
		      let hei=parseInt($('#saleBest .saleLists').css('height'));
		      if(hei<=100){
			      $('.navBottom').css('position','absolute');
			      $('.navBottom').css('width','100%');
			      $('.navBottom').css('left','50%');
			      $('.navBottom').css('bottom','0');
			      $('.navBottom').css('transform','translate(-50%, 0)');
		      }
	      })
      })
    </script>
@endsection
