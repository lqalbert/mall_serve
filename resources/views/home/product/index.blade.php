@extends('home.base')

@section('css')
    <link rel="stylesheet" href="/css/home/product/index.css"/>
@endsection

@section('content')
    <div id="product" class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1 col-sm-12 col-xs-12 productContent">
        <div class="productTitle col-lg-10 col-lg-offset-1 col-md-12 col-sm-12 col-xs-12">
            <a href="{{URL('/')}}">首页</a> >
            <a href="{{URL('product/index')}}">全部产品</a> >
            <a href="#">{{$name}}</a>
        </div>
        <div class="productBar col-lg-10 col-lg-offset-1 col-md-12 col-sm-12 col-xs-12">
            <div class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1 col-sm-12 col-xs-12 pls">
                <div class="btnBox col-lg-3 col-md-3 col-sm-4 col-xs-6">
                    <a href="{{URL('product/index?type=all')}}">
                        <div class="{{$type['all']}} col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            全部
                        </div>
                    </a>
                </div>
                <div class="btnBox col-lg-3 col-md-3 col-sm-4 col-xs-6">
                    <a href="{{URL('product/index?type=new')}}">
                        <div class="{{$type['new']}} col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            新品首发
                        </div>
                    </a>
                </div>
                <div class="btnBox col-lg-3 col-md-3 col-sm-4 col-xs-6">
                    <a href="{{URL('product/index?type=sale')}}">
                        <div class="{{$type['sale']}} col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            畅销产品
                        </div>
                    </a>
                </div>
                <div class="btnBox col-lg-3 col-md-3 col-sm-4 col-xs-6">
                    <a href="{{URL('product/index?type=wakeup')}}">
                        <div class="{{$type['wakeup']}} col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            焕肤紧致系列
                        </div>
                    </a>
                </div>
                <div class="btnBox col-lg-3 col-md-3 col-sm-4 col-xs-6">
                    <a href="{{URL('product/index?type=youth')}}">
                        <div class="{{$type['youth']}} col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            青春凝时冻龄系列
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="productLists col-lg-10 col-lg-offset-1 col-md-12 col-sm-12 col-xs-12">
            <a href="{{URL('product/product')}}">
                <div class="productBox col-lg-3 col-md-3 col-sm-4 col-xs-12">
                    <div class="productList col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <img src="/images/home/product/pro1.png" alt="">
                        <div class="msgPro col-lg-12 col-md-12 col-sm-12 col-xs12">
                            <div class="title col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                清透盈润面膜贴21片玻尿酸补水...
                            </div>
                            <div class="price col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <span>￥69.9</span>
                                <span class="high">￥297</span>
                                <span class="hot">热卖</span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            <a href="{{URL('product/product')}}">
                <div class="productBox col-lg-3 col-md-3 col-sm-4 col-xs-12">
                    <div class="productList col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <img src="/images/home/product/pro2.png" alt="">
                        <div class="msgPro col-lg-12 col-md-12 col-sm-12 col-xs12">
                            <div class="title col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                爆奶霜滋润补水锁水保湿面霜秋冬牛奶护肤擦脸润肤霜
                            </div>
                            <div class="price col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <span>￥69.9</span>
                                <span class="high">￥297</span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            <a href="{{URL('product/product')}}">
                <div class="productBox col-lg-3 col-md-3 col-sm-4 col-xs-12">
                    <div class="productList col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <img src="/images/home/product/pro3.png" alt="">
                        <div class="msgPro col-lg-12 col-md-12 col-sm-12 col-xs12">
                            <div class="title col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                爆奶霜滋润补水锁水保湿面霜秋冬牛奶护肤擦脸润肤霜
                            </div>
                            <div class="price col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <span>￥69.9</span>
                                <span class="high">￥297</span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            <a href="{{URL('product/product')}}">
                <div class="productBox col-lg-3 col-md-3 col-sm-4 col-xs-12">
                    <div class="productList col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <img src="/images/home/product/pro4.png" alt="">
                        <div class="msgPro col-lg-12 col-md-12 col-sm-12 col-xs12">
                            <div class="title col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                爆奶霜滋润补水锁水保湿面霜秋冬牛奶护肤擦脸润肤霜
                            </div>
                            <div class="price col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <span>￥69.9</span>
                                <span class="high">￥297</span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            <a href="{{URL('product/product')}}">
                <div class="productBox col-lg-3 col-md-3 col-sm-4 col-xs-12">
                    <div class="productList col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <img src="/images/home/product/pro5.png" alt="">
                        <div class="msgPro col-lg-12 col-md-12 col-sm-12 col-xs12">
                            <div class="title col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                清透盈润面膜贴21片玻尿酸补水...
                            </div>
                            <div class="price col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <span>￥69.9</span>
                                <span class="high">￥297</span>
                                <span class="hot">热卖</span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="enjoyProduct col-lg-10 col-lg-offset-1 col-md-12 col-sm-12 col-xs-12">
            <div class="enjoyTitle col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="left col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <span class="line"></span>
                    <span>猜你喜欢</span>
                </div>
            </div>
        </div>
        <div class="productLists col-lg-10 col-lg-offset-1 col-md-12 col-sm-12 col-xs-12">
            <a href="{{URL('product/product')}}">
                <div class="productBox col-lg-3 col-md-3 col-sm-4 col-xs-12">
                    <div class="productList col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <img src="/images/home/product/enjoy1.png" alt="">
                        <div class="msgPro col-lg-12 col-md-12 col-sm-12 col-xs12">
                            <div class="title col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                清透盈润面膜贴21片玻尿酸补水...
                            </div>
                            <div class="price col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <span>￥69.9</span>
                                <span class="high">￥297</span>
                                <span class="hot">热卖</span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            <a href="{{URL('product/product')}}">
                <div class="productBox col-lg-3 col-md-3 col-sm-4 col-xs-12">
                    <div class="productList col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <img src="/images/home/product/enjoy2.png" alt="">
                        <div class="msgPro col-lg-12 col-md-12 col-sm-12 col-xs12">
                            <div class="title col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                清透盈润面膜贴21片玻尿酸补水...
                            </div>
                            <div class="price col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <span>￥69.9</span>
                                <span class="high">￥297</span>
                                <span class="hot">热卖</span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            <a href="{{URL('product/product')}}">
                <div class="productBox col-lg-3 col-md-3 col-sm-4 col-xs-12">
                    <div class="productList col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <img src="/images/home/product/enjoy3.png" alt="">
                        <div class="msgPro col-lg-12 col-md-12 col-sm-12 col-xs12">
                            <div class="title col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                清透盈润面膜贴21片玻尿酸补水...
                            </div>
                            <div class="price col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <span>￥69.9</span>
                                <span class="high">￥297</span>
                                <span class="hot">热卖</span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            <a href="{{URL('product/product')}}">
                <div class="productBox col-lg-3 col-md-3 col-sm-4 col-xs-12">
                    <div class="productList col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <img src="/images/home/product/enjoy4.png" alt="">
                        <div class="msgPro col-lg-12 col-md-12 col-sm-12 col-xs12">
                            <div class="title col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                清透盈润面膜贴21片玻尿酸补水...
                            </div>
                            <div class="price col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <span>￥69.9</span>
                                <span class="high">￥297</span>
                                <span class="hot">热卖</span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            <a href="{{URL('product/product')}}">
                <div class="productBox col-lg-3 col-md-3 col-sm-4 col-xs-12">
                    <div class="productList col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <img src="/images/home/product/enjoy5.png" alt="">
                        <div class="msgPro col-lg-12 col-md-12 col-sm-12 col-xs12">
                            <div class="title col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                清透盈润面膜贴21片玻尿酸补水...
                            </div>
                            <div class="price col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <span>￥69.9</span>
                                <span class="high">￥297</span>
                                <span class="hot">热卖</span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            <a href="{{URL('product/product')}}">
                <div class="productBox col-lg-3 col-md-3 col-sm-4 col-xs-12">
                    <div class="productList col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <img src="/images/home/product/enjoy6.png" alt="">
                        <div class="msgPro col-lg-12 col-md-12 col-sm-12 col-xs12">
                            <div class="title col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                清透盈润面膜贴21片玻尿酸补水...
                            </div>
                            <div class="price col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <span>￥69.9</span>
                                <span class="high">￥297</span>
                                <span class="hot">热卖</span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            <a href="{{URL('product/product')}}">
                <div class="productBox col-lg-3 col-md-3 col-sm-4 col-xs-12">
                    <div class="productList col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <img src="/images/home/product/enjoy7.png" alt="">
                        <div class="msgPro col-lg-12 col-md-12 col-sm-12 col-xs12">
                            <div class="title col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                清透盈润面膜贴21片玻尿酸补水...
                            </div>
                            <div class="price col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <span>￥69.9</span>
                                <span class="high">￥297</span>
                                <span class="hot">热卖</span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            <a href="{{URL('product/product')}}">
                <div class="productBox col-lg-3 col-md-3 col-sm-4 col-xs-12">
                    <div class="productList col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <img src="/images/home/product/enjoy8.png" alt="">
                        <div class="msgPro col-lg-12 col-md-12 col-sm-12 col-xs12">
                            <div class="title col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                清透盈润面膜贴21片玻尿酸补水...
                            </div>
                            <div class="price col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <span>￥69.9</span>
                                <span class="high">￥297</span>
                                <span class="hot">热卖</span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function () {
        })
    </script>
@endsection