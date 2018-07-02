@extends('home.base')
@section('css')
    <link rel="stylesheet" href="/css/home/sale/stars.css"/>
@endsection

@section('nav')
@include("home.nav",['bar' => $bar])
@endsection

@section('content')
    <div id="stars" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="starsTitle col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <a href="{{URL('/')}}">首页</a>>
            <a href="{{URL('product/index')}}">全部产品</a>>
            <span>明星系列</span>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 productTit">
            <div class="col-lg-6 col-lg-offset-3 col-md-6 col-sm-8 col-xs-12">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <a href="{{ route('sale/stars', ['cate_id'=>'3'])  }}" class="{{$type['wakeup']}}">金致焕肌系列</a>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <a href="{{ route('sale/stars', ['cate_id'=>'4'])  }}" class="{{$type['youth']}}">
                        水嫩保湿系列
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 productBanners">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 left">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 lefBox">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 tits">
                        PULATA Brighten Series
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 minTit">
                        @if($yt=='wakeup')
                            普拉她  金致焕肌系列
                        @else
                            普拉她  水嫩保湿系列
                        @endif
                        <div class="line"></div>
                    </div>
                    @if($yt=='wakeup')
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 tet">
                            <p>专为亚洲肌肤研制</p>
                            <p>层层修护</p>
                            <p>打造年轻嘭弹肌肤</p>
                        </div>
                    @else
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 tet">
                            <p>打开肌肤补水通道</p>
                            <p>全新水漾感受</p>
                            <p>滴滴精华滋养</p>
                        </div>
                    @endif
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 lefCon">
                        @if($yt=='wakeup')
                            普拉她金致焕肌系列每一样产品都注入多种“紧致抗衰”成分，全方面缓解肌肤的衰老速度，修护肌肤屏障问题，为轻熟肌带来多种解决对策。多效驻颜，闪耀年轻光采。
                        @else
                            普拉她水嫩保湿系列致力于补水保湿，严格选取不增加肌肤负担的原料，将自然的活性成分和科技力量完美融合，质地温和水润清爽，由内而外唤醒肌肤鲜活能量。
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 right">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 imgBox">
                    @if($yt=='wakeup')
                        <img src="/images/2018-06-27/s2.png" alt="">
                    @else
                        <img src="/images/2018-06-27/s1.jpg" alt="">
                    @endif
                </div>
            </div>
        </div>

        <!--             <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 proLists"> -->
        <!--                 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 proList"> -->
    <!--                     <a href="{{URL('product/product')}}"> -->
        <!--                         <div class="imgB col-lg-12 col-md-12 col-sm-12 col-xs-12"> -->
        <!--                             <img src="/images/home/sale/mxcp.jpg" alt=""> -->
        <!--                         </div> -->
        <!--                         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 proTit"> -->
        <!--                             护肤品套装面部护理保湿锁水爽肤水保湿霜乳液化妆水 -->
        <!--                         </div> -->
        <!--                         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 priceBox"> -->
        <!--                             <span class="price">￥119</span> -->
        <!--                             <span class="saleN">新品</span> -->
        <!--                             <span class="saleN saleB">畅销</span> -->
        <!--                             <span class="shop"> -->
        <!--                             <img src="/images/home/sale/shopping.jpg" alt=""> -->
        <!--                         </span> -->
        <!--                         </div> -->
        <!--                     </a> -->
        <!--                 </div> -->
        <!--             </div> -->

        @foreach($allGoods as $goods)
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 proLists">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 proList">
                    <a href="{{URL("product",['id'=>$goods->id])}}" title="{{$goods->goods_name}}">
                        <div class="imgB col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <img src="{{$goods->cover_url or ''}}" height="244" alt="">
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 proTit">
                            {{$goods->goods_name}}
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 priceBox">
                            <span class="price">￥{{$goods->getPrice()}}</span>
                            @if(!empty($goods->new_goods))
                                <span class="saleN">新品</span>
                            @endif
                            @if(!empty($goods->hot_goods))
                                <span class="saleN saleB">畅销</span>
                            @endif
                        </div>
                    </a>
                </div>
            </div>
    @endforeach




    <!--             <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 proLists"> -->
        <!--                 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 proList"> -->
    <!--                     <a href="{{URL('product/product')}}"> -->
        <!--                         <div class="imgB col-lg-12 col-md-12 col-sm-12 col-xs-12"> -->
        <!--                             <img src="/images/home/sale/mxcp.jpg" alt=""> -->
        <!--                         </div> -->
        <!--                         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 proTit"> -->
        <!--                             护肤品套装面部护理保湿锁水爽肤水保湿霜乳液化妆水 -->
        <!--                         </div> -->
        <!--                         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 priceBox"> -->
        <!--                             <span class="price">￥119</span> -->
        <!--                             <span class="saleN">新品</span> -->
        <!--                             <span class="saleN saleB">畅销</span> -->
        <!--                             <span class="shop"> -->
        <!--                             <img src="/images/home/sale/shopping.jpg" alt=""> -->
        <!--                         </span> -->
        <!--                         </div> -->
        <!--                     </a> -->
        <!--                 </div> -->
        <!--             </div> -->


    </div>
@endsection
@section('js')
    <script>
      $(document).ready(function () {

      })
    </script>
@endsection
