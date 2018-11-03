<div class="container-fluid navContent">
    <div class="container logoContent">
        <div class="row">
            <div class="col-lg-4 col-md-4 logo">
                <img src="/images/web/logos.png" alt="">
            </div>
            <div class="col-lg-4 col-md-4">
                <div class="searchBox">
                    <input type="text" class="search" id="seachText" placeholder="水嫩保湿" >
                    <img src="/images/web/search.png" alt="" id="searchButton">
                </div>
            </div>
            <div class="col-lg-4 col-md-4">
                <div class="tels">
                    <div class="hol">Hotline</div>
                    400-158-2369
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid navbContent">
        <div class="container" style="padding: 0;" role="navigation">
            <ul class="nav nav-pills nav-justified">
            
                <li 
                @if($nav=='index')
                	class="active"
                @endif
                ><a href="/"><span class="ink"></span>首页</a></li>
                <li
                @if($nav=='cate' && $cate_id==10)
                	class="active"
                @endif
                ><a href="/product/index?cate_id=10"><span class="ink"></span>臻品面膜系列</a></li>
                <li
                @if($nav=='cate' && $cate_id==3)
                	class="active"
                @endif
                ><a href="/product/index?cate_id=3"><span class="ink"></span>金致焕肌系列</a></li>
                <li
                 @if($nav=='cate' && $cate_id==4)
                	class="active"
                @endif
                ><a href="/product/index?cate_id=4"><span class="ink"></span>水嫩保湿系列</a></li>
                <li
                 @if($nav=='cate' && $cate_id==2)
                	class="active"
                @endif
                ><a href="/product/index?cate_id=2"><span class="ink"></span>美妆产品</a></li>
                <li
                 @if($nav=='cate' && $cate_id==1)
                	class="active"
                @endif
                ><a href="/product/index?cate_id=1"><span class="ink"></span>滋润护肤</a></li>
                <li
                 @if($nav=='cate' && $cate_id==25)
                	class="active"
                @endif
                ><a href="/product/index?cate_id=25"><span class="ink"></span>营养饮品</a></li>
                <li
                @if($nav=='brand')
                	class="active"
                @endif
                ><a href="/brand/index"><span class="ink"></span>品牌故事</a></li>
                <li><a href="#"><span class="ink"></span>联系我们</a></li>
            </ul>
        </div>
    </div>
</div>