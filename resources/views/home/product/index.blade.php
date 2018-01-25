@extends('home.base')

@section('css')
    <link rel="stylesheet" href="/css/home/product/index.css"/>
@endsection

@section('content')
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 productBanner">
        <img src="/images/home/product/banner.jpg" style="width: 100%;" alt="">
    </div>
<!--     <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 searchBar"> -->
<!--         <div class="col-lg-10 col-lg-offset-1 col-md-12 col-sm-12 col-xs-12 lle"> -->
<!--             <div class="col-lg-10 col-lg-offset-1 col-md-12 col-sm-12 col-xs-12 llf"> -->
<!--                 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> -->
<!--                     <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1 col-sm-12 col-xs-12 search"> -->
<!--                         <input id="search" type="text" class="input"> -->
<!--                         <span id="searchs"  class="glyphicon glyphicon-search" aria-hidden="true"></span> -->
<!--                     </div> -->
<!--                 </div> -->
<!--                 <div id="searchLists" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 searchLists"> -->
<!--                     <div class="col-lg-2 col-lg-offset-1 col-md-3 col-sm-4 col-xs-6 searchList"> -->
<!--                         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 searchListBar sta">全部</div> -->
<!--                     </div> -->
<!--                     <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6 searchList"> -->
<!--                         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 searchListBar">保湿柔肤系列</div> -->
<!--                     </div> -->
<!--                     <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6 searchList"> -->
<!--                         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 searchListBar">清爽控油系列</div> -->
<!--                     </div> -->
<!--                     <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6 searchList"> -->
<!--                         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 searchListBar">抗皱舒缓系列</div> -->
<!--                     </div> -->
<!--                     <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6 searchList"> -->
<!--                         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 searchListBar">超值套装系列</div> -->
<!--                     </div> -->
<!--                 </div> -->
<!--             </div> -->
<!--         </div> -->
<!--     </div> -->
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 productLists">
        <div class="col-lg-10 col-lg-offset-1 col-md-12 col-sm-12 col-xs-12 lls">
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 productList">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 box">
                    <a href="{{URL('product/product')}}?id=1">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <img src="/images/home/product/product.jpg" style="width: 100%" alt="">
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 title">
                                清爽保湿套装
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 price">
                                <span style="color: #333">原价：198</span>&nbsp;&nbsp;&nbsp;
                                <span style="color: red">现价：99</span>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 productList">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 box">
                    <a href="{{URL('product/product')}}?id=2">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <img src="/images/home/product/product.jpg" style="width: 100%" alt="">
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 title">
                                清爽保湿套装
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 price">
                                <span style="color: #333">原价：198</span>&nbsp;&nbsp;&nbsp;
                                <span style="color: red">现价：99</span>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 productList">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 box">
                    <a href="{{URL('product/product')}}?id=3">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <img src="/images/home/product/product.jpg" style="width: 100%" alt="">
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 title">
                                清爽保湿套装
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 price">
                                <span style="color: #333">原价：198</span>&nbsp;&nbsp;&nbsp;
                                <span style="color: red">现价：99</span>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 productList">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 box">
                    <a href="{{URL('product/product')}}?id=4">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <img src="/images/home/product/product.jpg" style="width: 100%" alt="">
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 title">
                                清爽保湿套装
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 price">
                                <span style="color: #333">原价：198</span>&nbsp;&nbsp;&nbsp;
                                <span style="color: red">现价：99</span>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 productList">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 box">
                    <a href="{{URL('product/product')}}?id=5">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <img src="/images/home/product/product.jpg" style="width: 100%" alt="">
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 title">
                                清爽保湿套装
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 price">
                                <span style="color: #333">原价：198</span>&nbsp;&nbsp;&nbsp;
                                <span style="color: red">现价：99</span>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 productList">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 box">
                    <a href="{{URL('product/product')}}?id=6">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <img src="/images/home/product/product.jpg" style="width: 100%" alt="">
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 title">
                                清爽保湿套装
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 price">
                                <span style="color: #333">原价：198</span>&nbsp;&nbsp;&nbsp;
                                <span style="color: red">现价：99</span>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 productList">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 box">
                    <a href="{{URL('product/product')}}?id=7">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <img src="/images/home/product/product.jpg" style="width: 100%" alt="">
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 title">
                                清爽保湿套装
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 price">
                                <span style="color: #333">原价：198</span>&nbsp;&nbsp;&nbsp;
                                <span style="color: red">现价：99</span>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 productList">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 box">
                    <a href="{{URL('product/product')}}?id=8">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <img src="/images/home/product/product.jpg" style="width: 100%" alt="">
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 title">
                                清爽保湿套装
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 price">
                                <span style="color: #333">原价：198</span>&nbsp;&nbsp;&nbsp;
                                <span style="color: red">现价：99</span>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 productList">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 box">
                    <a href="{{URL('product/product')}}?id=9">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <img src="/images/home/product/product.jpg" style="width: 100%" alt="">
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 title">
                                清爽保湿套装
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 price">
                                <span style="color: #333">原价：198</span>&nbsp;&nbsp;&nbsp;
                                <span style="color: red">现价：99</span>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function () {
            $('#searchLists .searchListBar').on('click',function () {
                $('#searchLists .searchListBar').removeClass('sta')
                $(this).addClass('sta')
            })
            $('#searchs').on('click',function () {
                var con=$('#search').val()
                console.log(con)
            })
        })
    </script>
@endsection