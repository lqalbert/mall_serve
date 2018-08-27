@extends('home.base')
@section('css')
    <link rel="stylesheet" href="/css/home/information/company.css"/>
@endsection

@section('nav')
    @include("home.nav",['bar' => $bar])
@endsection

@section('content')
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 companyContent">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 title">
            关于我们
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 minTitle">
            公司简介：
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 msgContent">
            广州普拉她生物科技有限公司坐落于广州番禺区,公司致力于女性更美丽、更自信、更幸福，依靠产品帮助女性找回美丽、找回自信、并深入女性内心的情感和需求，帮助女性觉醒，让她们真正享受美丽、享受自信、享受生活。
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 msgContent">
            普拉她-唤醒你的美，公司主要产品均围绕女人的健康、美丽开展，旨在第一时间为女性消费者提供优质的产品以及满意的服务，致力打造女性专属的以女性自身以及家庭为导向的中国知名的女性综合电商平台。
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 minTitle">
            公司企业文化：
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 msgContent">
            公司理念：拼搏、创业、协同、共赢。
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 minTitle">
            公司理念：
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 msgContent">
            致力于女性健康与美丽，不断提供优质贴心的产品与服务，让女性更加健康、美丽、自信，与她们一起共享美丽人生。
        </div>
    </div>
@endsection
@section('js')

@endsection