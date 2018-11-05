@extends('home.base')
@section('css')
    <link rel="stylesheet" href="/css/home/question/index.css"/>
@endsection

@section('nav')
@include("home.nav",['nav' => 'brand'])
@endsection

@section('content')
    <div id="question" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="questionContent col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="left col-lg-2 col-md-3 col-sm-3 col-xs-12">
                <div class="barBox col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="listBar col-lg-12 col-md-12 col-sm-12 col-xs-12 actionBar">常见问题</div>
                    {{--<div class="listBar col-lg-12 col-md-12 col-sm-12 col-xs-12">购买相关</div>--}}
                    <div class="listBar col-lg-12 col-md-12 col-sm-12 col-xs-12">退换货问题</div>
                    {{--<div class="listBar col-lg-12 col-md-12 col-sm-12 col-xs-12">售后服务</div>--}}
                </div>
            </div>
            <div class="right col-lg-10 col-md-9 col-sm-9 col-xs-12">
                <div class="rightContent col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 saleQuestion">
                        <div class="title col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            常见问题
                        </div>
                        <div class="questionList col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="question col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <span></span>拍了什么时候能发货呢？
                            </div>
                            <div class="answer col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                您好，订单非活动期间会在您拍付的48小时内发送！
                            </div>
                        </div>
                        <div class="questionList col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="question col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <span></span>普拉她的订单如何配送？
                            </div>
                            <div class="answer col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                普拉她会根据商品所在地、顾客所在地和商品的尺寸重量优选物流配送商，确保优质用户体验。
                            </div>
                        </div>
                        <div class="questionList col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="question col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <span></span>已经发货了不想要怎么办？
                            </div>
                            <div class="answer col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                您好，已经发货包裹开启可以在工作日内联系咱们商城客服提供单号，咱们为你联系快递员退回包裹处理，因为发送中途包裹无法保证百分之百可以拦截退回，您记得在快递联系您的时候拒收包裹哦，咱们收到退回的包裹会为您办理退款！
                            </div>
                        </div>
                        <div class="questionList col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="question col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <span></span>发了好多天了怎么一直收不到呢？
                            </div>
                            <div class="answer col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                您好，麻烦您提供下您的订单联系客服或者您的老师，我们为您联系快递核实查询，核实后第一时间联系你，如出现物流问题我们会催促快递给您优先安排处理！
                            </div>
                        </div>
                        <div class="questionList col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="question col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <span></span>为什么一直联系不到客服？
                            </div>
                            <div class="answer col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                您好，我们的客服上班时间为早上8点30分--晚上21点30分<br/>
                                客服热线：400  158  2369
                            </div>
                        </div>
                        <div class="questionList col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="question col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <span></span>收到的货物漏发或错发了怎么办？
                            </div>
                            <div class="answer col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                您好，对于您遇到这个事情十分抱歉，麻烦您提供下收到产品照片+漏发或错发产品名字告诉我们，我们会为您联系配送中心核查，核查后会安排进行补发或更正发货!
                        </div>
                        <div class="questionList col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="question col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <span></span>如何办理退款？
                            </div>
                            <div class="answer col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                您好，如需办理退款，您需要联系客服为您安排退款，一般退款到账时间为一周左右。
                            </div>
                        </div>
                        <div class="questionList col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="question col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <span></span>7天无理由退换货申请规则？
                            </div>
                            <div class="answer col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                您好，收到商品后，7天无理由退/换货，以下情况除外：<br>
                                a、买家自身原因造成商品破损；<br>
                                b、买家已是使用产品（无质量问题），并影响到二次销售；<br>
                                因主观原因要求的退货：<br>
                                a、因主观原因（不喜欢、与想象不同）要求的退货，须自行承担往返运费。收到您的货品后检查未开封、未使用，不影响二次销售的情况下，将办理退换货；<br>
                                b、若收到货检查产品影响二次销售仓库将拒收，无法办理退换货。
                            </div>
                        </div>
                        <div class="questionList col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="question col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <span></span>护肤产品基本使用步骤？
                            </div>
                            <div class="answer col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                护肤的基本步骤：<br>
                                白天：洁面、爽肤水、小黑瓶/面部精华、面部乳液/白霜、眼部精华、眼霜、防晒隔离。<br>
                                晚上：卸妆、洁面、爽肤水、小黑瓶/面部精华、晚霜、眼部精华、眼霜。
                            </div>
                        </div>
                        <div class="questionList col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="question col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <span></span>彩妆产品的基本使用步骤？
                            </div>
                            <div class="answer col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                彩妆的基本步骤：隔离-粉底-遮瑕-粉饼/散粉/蜜粉-腮红-眼影-眼线-睫毛膏-眉笔-润唇膏-唇膏/唇彩/唇釉。
                            </div>
                        </div>
                    </div>
                </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 returnGoods">
                        <div class="title col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            退换问题
                        </div>
                        <div class="questionList col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="question col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <span></span>退/换货（皮肤过敏）？
                            </div>
                            <div class="answer col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                您在使用我们产品时如有过敏现象，在签收15天（包含签收当天）之内可申请退货（须附上过敏照片，医院的皮肤诊断证明），签收使用产品15天后对过敏性问题不在负责。
                            </div>
                        </div>
                        <div class="questionList col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="question col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <span></span>退/换货（产品质量）？
                            </div>
                            <div class="answer col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                客户在收到产品3天（包含签收当天）之内发现有明显的质量问题，我们会予以安排退/换货，超过3天则不受理。提供退/换货申请后，客服会在第一时间跟您进行联系，给予及时处理（产品包材问题需附上照片），申请成功后，我们将安排产品的更换配送。
                            </div>
                        </div>
                        <div class="questionList col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="question col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <span></span>退/换货（非产品质量）？
                            </div>
                            <div class="answer col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                如果您收到的货物与您订购的产品有出入，您可以在收到产品7天内与客服联系，我们将为您提供退/换货服务。退还订购的产品，请确保所有产品未开封及附上送货单据明细，还有送货单和发票上注明的其他物品，将退回您的货款。
                            </div>
                        </div>
                        <div class="questionList col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="question col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <span></span>退换产品运费处理？
                            </div>
                            <div class="answer col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                如果因为普拉她的工作失误造成退货（收到的产品并非订购的产品，或包装出现损坏等），退款中将包含您支付的运费。
                            </div>
                        </div>
                        <div class="questionList col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="question col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <span></span>退货流程？
                            </div>
                            <div class="answer col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                a、联系客服进行退货申请。<br>
                                b、在必要情况下提供产品质量问题证明（产品损坏等）。<br>
                                c、根据客服人员提示将订单快递寄回。<br>
                                d、快递到达仓库，7个工作日内安排退款。<br>
                                e、耐心等待银行到账信息提示。
                            </div>
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
      	$('#question .left .listBar').on('click',function () {
          $('#question .left .listBar').removeClass('actionBar');
          $(this).addClass('actionBar');
          let con=$(this).text();
          if(con === '常见问题'){
          	$('.saleQuestion').show();
          	$('.returnGoods').hide();
          }else if(con === '退换货问题'){
            $('.saleQuestion').hide();
            $('.returnGoods').show();
          }
        })
      })
    </script>
    <script>
	@if($current == 'exaq')
		$(document).ready(function(){
			$('#question .left .listBar:last-child').trigger("click");
		})
	@endif
    </script>
@endsection