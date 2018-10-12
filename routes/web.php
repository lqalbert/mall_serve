<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//[ 'namespace' => 'Admin','domain' => env('ADMIN_DOMAIN', 'admin.mall')



if (env('APP_ENV') != "production") {
    $logGroup = ['prefix'=>'admin', 'namespace' => 'Admin'];
    $adminGroup = ['prefix'=>'admin', 'namespace' => 'Admin', 'middleware'=>'auth'];
} else {
    $logGroup = [ 'namespace' => 'Admin','domain' => env('ADMIN_DOMAIN', 'admin.mall')];
    $adminGroup = ['namespace' => 'Admin', 'middleware'=>'auth', 'domain' => env('ADMIN_DOMAIN', 'admin.mall') ];
}



Route::group($logGroup, function(){
    Route::get('/', 'IndexController@index');
    //登录 退出
    Route::post('/login', 'LoginController@login');
    Route::post('/logout', 'LoginController@out');
    Route::get('/set-sender', 'WayBillController@setSender');
});

    //['namespace' => 'Admin', 'middleware'=>'auth.basic', 'domain' => env('ADMIN_DOMAIN', 'admin.mall') ]
Route::group($adminGroup, function(){

    Route::post('/upload-file', 'UploadController@index')->name('upload');
	Route::resource('/deposits', 'DepositController');
	
	Route::get('/categorys/{lel}','CategoryController@getLevels');
	Route::get('/getCategorys/{pid}','CategoryController@getChildrens');
	Route::resource('/categorys','CategoryController');
	Route::get('/tree','CategoryController@getCascade');
	Route::get('/deleteCategory/{id}','CategoryController@haveChildren');
	Route::resource('/customers','CustomerController');
	Route::match(['put','patch','post'], '/customers-transfer', 'CustomerController@transfer');
	Route::match(['put','patch','post'], '/customers-quit-transfer', 'CustomerController@quitTransfer');
	Route::get('/customers-front-ledin', 'CustomerController@frontLedIn');
	Route::put('/customers-transfer-front-ledin', 'CustomerController@transferFrontLedIn');
	Route::get('/customers-get-allow', 'CustomerController@getNumAllowAllocat');
	Route::get('/customers-allocate-user', 'CustomerController@allocateToUser');
	
	Route::get('/getUsersByGid/{gid}','EmployeeController@getUserByGId');
	Route::get('/getGroupsByPid/{pid}','GroupController@getGroupsByPid');
	Route::get('/getDepartmentByType/{type}','DepartmentController@getDepartmentByType');

	
	Route::resource('/orderlist','OrderListController');
	Route::resource('/buyorders','BuyOrderController');
// 	Route::resource('/users','EmployeeController');
	Route::resource('/employees','EmployeeController');
	Route::match(['put','patch'], '/employeesupdate', 'EmployeeController@updates');
	//passowrd/2 put patch
	Route::match(['put','patch'], '/passowrd/{id}', 'EmployeeController@changePassword');
	Route::resource('/buyers','CustomerController');
	Route::resource('/inventorylist','InventoryListController');
	Route::resource('/departments','DepartmentController');
	Route::resource('/groups','GroupController');
	
	Route::resource('/expressinfo','ExpressInfoController');
	
	Route::resource('/roles','RoleController');
	Route::get('/roles-assignable','RoleController@assignable');
	
	
	Route::resource('/goodsdetails','GoodsDetailsController');
	Route::resource('/customer-contact','CustomerContactController');
	Route::resource('/departments','DepartmentController');
	// Route::resource('/orderlists','OrderListController');
	Route::resource('/ordergoods','OrderGoodsController');
	
	Route::resource('/goodsout','GoodsOutController');
	Route::resource('/goodsinto','GoodsIntoController');
	Route::resource('/goodsspecs','GoodsSpecsController');
	Route::resource('/goodstype','GoodsTypeController');
	Route::resource('/goodssku', 'GoodsSkuController');
	Route::get('/goodstypelist','GoodsTypeController@goodsTypeList');
	Route::resource('/deliveryaddress','DeliveryAddressController');
	Route::match(['put','post'], '/updateCheckStatus/{id}', 'OrderBasicController@updateCheckStatus');
	Route::match(['put','post'], '/order-cancel/{id}', 'OrderBasicController@cancel');
	Route::resource('/orderbasic','OrderBasicController');
	
	Route::resource('/articles' , 'ArticleController');
	Route::resource('/connection' , 'ConnectionController');
	Route::resource('/skincareinfo','SkinCateInfoController');
	Route::resource('/sysnotice','SysNoticeController');
	Route::resource('/contacts','ContactsController');
	Route::resource('/website','WebsiteController');
	Route::resource('/distributioncenter','DistributionCenterController');
	Route::resource('/shelvesmanagement','ShelvesManagementController');

	Route::get('/expresscompany-address/{id}','ExpressCompanyController@getAddress');
	Route::put('/expresscompany-address/{id}','ExpressCompanyController@updateAddress');
	Route::resource('/expresscompany','ExpressCompanyController');//entrepot-product-count
	Route::get('/menus', 'NavController@getNav');
	
	Route::resource('/produce-entry', 'ProduceEntryController');
	Route::get('/getsalelockdata', 'ProduceEntryController@GetSaleLockData');
	Route::get('/entrepot-product-count/{sku_sn}', 'EntrepotProductController@getEntrepotProductCount');
	Route::get('/entrepot-combo-count/{sku_sn}', 'EntrepotProductController@ComboCount');
	Route::put('/entrepot-combo-operat', 'EntrepotProductController@addCombo');
	Route::put('/order-assign-check', 'AssignController@check');//----
	Route::resource('/order-assign', 'AssignController');

	Route::get('/assign-expresssn/{express_sn}', 'AssignController@showbyExpressSn');
	Route::put('/order-assign-check/{id}', 'AssignController@check');//----
	Route::put('/order-assign-repeat/{id}', 'AssignController@repeatOrder');
	Route::put('/order-assign-stop/{id}',  'AssignController@stopOrder');
	Route::post('/assign-waybill-print/{id}', 'AssignController@waybillPrint');
	Route::post('/assign-waybill-prints', 'AssignController@waybillPrints');
	Route::post('/assign-goods-print/{id}', 'AssignController@goodsPrint');
	Route::get('/assign-goods-prints', 'AssignController@goodsPrint2');
	Route::put('/assign-checkgoods/{id}', 'AssignController@checkGoods');
	Route::put('/assign-weight/{id}', 'AssignController@weightGoods');
	Route::put('/assign-update-waybill/{id}', 'AssignController@updateWayBill');
	Route::put('/assign-percelon/{id}', 'AssignController@parcelOn');
	Route::put('/assign-sign/{id}', 'AssignController@orderSign');
	
	Route::resource('/entrepot-badgoods', 'EntrepotBadgoodsController');
	Route::resource('/inventory-exchange', 'InventoryExchangeController');
    
	
	Route::get('/inventory-gather', 'InventoryGatherController@index');
	//库存明细 不靠谱的
	Route::get('/inventory-detail', 'InventoryDetailController@index');
	
	Route::get('/entry-product', 'EntryProductController@index');
	Route::resource('/expressreceive', 'ExpressReceiveController');
	Route::get('/shelvespick', 'ShelvesPickController@index');
	Route::resource('/shelvespick', 'ShelvesPickController');
	Route::resource('/stockoutdetails', 'StockOutDetailsController');
	Route::get('/distribution-delivery', 'DistributionDeliveryController@index');

	Route::resource('/order-address','OrderAddressController');
	Route::resource('/stock-warning','StockWarningController');
	
	Route::resource('/order-after-sale', 'AfterSaleController');
// 	Route::resource('/after-goods', 'AfterGoodsController');
	
	Route::resource('/return-record', 'ReturnRecordController');
	
	Route::get('/order-operate-records', 'OrderOperateController@index');

	Route::resource('/area','AreaInfoController');
	Route::resource('/track-log','CustomerTrackLogController');
	Route::resource('/plan','PlanController');
	Route::resource('/complain','CustomerComplainController');
	Route::resource('/communicate','CommunicateController');
	
// 	Route::get('/print/{id}', 'PrintController@index');
	Route::get('/print/assign/{id}', 'PrintController@printAssign');
	
	Route::resource('/express-invoices', 'ExpressInvoicesController');
	Route::resource('/assign-invoices',  'AssignInvoicesController');
	Route::resource('/cartonmanagement',  'CartonManagementController');
	Route::resource('/volumeratio',  'VolumeRatioController');
	Route::resource('/expresscompensation',  'ExpressCompensationController');
	Route::resource('/expressprice',  'ExpressPriceController');
	Route::get('/aaa',  'CartonManagementController@goods_carton');
    
	Route::put('/stock-check-goods-entrepot/{id}',  'StockCheckGoodsController@updateEntrepot');
	Route::resource('/stock-check-goods',  'StockCheckGoodsController');
	Route::resource('/stock-check',  'StockCheckController');
	Route::get('/get-check-goods',  'StockCheckController@getCheckGoods');
	Route::get('/get-goods-price/{sku}',  'StockCheckController@getGoodsPrice');
	
	//电子面单
	Route::get('/getOne/{assign_id}/{express_id}', 'WayBillController@getOne')
	->where(['assign_id'=>'[0-9]+','express_id' => '[0-9]+', 'order_id' => '[0-9]+']);
	Route::put('/order-after-sale-check/{id}', 'AfterSaleController@checkStatus');
	Route::put('/order-after-sale-sure/{id}', 'AfterSaleController@sureStatus');
	Route::get('/cus-all-info/{id}', 'AfterSaleController@getCusAllInfo');
	
	Route::resource('/purchaseorder',  'PurchaseOrderController');
	Route::resource('/purchaseordergoods',  'PurchaseOrderGoodsController');
	Route::resource('/actualdeliveryexpress',  'ActualDeliveryExpressController');
	Route::resource('/actualdeliverygoods',  'ActualDeliveryGoodsController');
	
	Route::get('/sale-quan', 'SaleQuanController@index');
    Route::get('/salesperformance',  'SalesPerformanceController@index');
    Route::get('/salesperformance-selectorder',  'SalesPerformanceController@selectOrder');
    Route::put('/deposit-revoke/{id}','DepositController@revoke');
    
    Route::resource('/freight-template',  'FreightTemplateController');
    Route::resource('/freight-extra',  'FreightExtraController');
    Route::resource('/order-type',  'OrderTypeController');

    Route::get('/assign-operate-records', 'AssignOperationController@index');
    Route::put('/order-assign-editexpressfee/{id}', 'AssignController@editExpressFee');//发货单修改实付运费
    Route::resource('/logisticsinformation',  'LogisticsInformationController');
    Route::resource('/slidemanage',  'SlideManageController');
    Route::resource('/slideuploadpicture',  'SlideUploadPictureController');
    Route::post('/slide-upload',  'SlideManageController@slideUpload');
    Route::put('/mail/waybill',  'MailController@getWaybillCode');
    Route::get('/mail/print',  'MailController@waybillPrint');
    Route::resource('/mail',  'MailController');
    Route::resource('/mail-goods',  'MailGoodsController');

    Route::resource('/freight-template',  'FreightTemplateController');
    Route::resource('/freight-extra',  'FreightExtraController');

    Route::resource('/order-deposit-log',  'OrderDepositLogController');//订单保证金日志
    
    Route::put('/order-after-inventory/{id}', 'AfterSaleController@inventory');

    Route::resource('/sales-goods-statistics','SalesGoodsStatisticsController');
    Route::resource('/sample-application','SampleApplicationController');
    Route::resource('/questionnairemanagement', 'QuestionnaireManagementController');
    Route::resource('/questionnairesurveyresults', 'QuestionnaireSurveyResultsController');
    //前台分类
    Route::resource('/front-category', 'CategoryFrontController');
    Route::put('/goodsdetails-front-detach/{id}', 'GoodsDetailsController@frontDetach');
    // Route::get('/sales-goods-statistics','SalesGoodsStatisticsController@index');
    Route::put('/order-after-in-inventory/{id}', 'AfterSaleController@rxInventory');
    Route::put('/order-after-out-inventory/{id}', 'AfterSaleController@outInventory');
    //套餐
    Route::resource('/goods-combo', 'ComboController');
    Route::resource('/accountsettings', 'AccountSettingsController');
    Route::match(['put','patch'], '/accountsettingsupdate', 'AccountSettingsController@updates');
    //商品统计-部门
    Route::put('/sales-goods-statistics-dep/{sku}','SalesGoodsStatisticsController@getDepSaleGoods');
    Route::get('/sales-goods-statistics-download-excel','SalesGoodsStatisticsController@downloadExcel');
    Route::resource('/questionnaireoptions', 'QuestionnaireOptionsController');
    //测试JD订单导入数据处理
    Route::get('/test-import-order','JdOrderImportController@index');

});


	
// Route::get('/', function () {
// 	// return view('welcome');
// 	return view('test/test');
// });




Route::get('/', 'Home\IndexController@index')->middleware('mobiledetected');


Route::get('/product/index', 'Home\ProductController@index')->name('product/index')->middleware('mobiledetected');
Route::get('/product/product', 'Home\ProductController@product')->name('product/product')->middleware('mobiledetected');
Route::get('/product/{id}', 'Home\ProductController@product')->name('product/product')->middleware('mobiledetected');
Route::get('/brand/index', 'Home\BrandController@index')->name('brand/index');
// Route::get('/login/index', 'Home\LoginController@index')->name('login/index');
// Route::get('/login/loginOut', 'Home\LoginController@loginOut')->name('login/loginOut');
// Route::get('/login/register', 'Home\LoginController@register')->name('login/register');
Route::get('/information/index/{id}', 'Home\InformationController@index')->name('information/index');
Route::get('/information/news', 'Home\InformationController@news')->name('information/news');
Route::get('/information/company', 'Home\InformationController@company');
Route::get('/information/{id}', 'Home\InformationController@detail');
Route::post('/connection/store', 'Home\ConnectionController@store');
Route::get('/connection/index', 'Home\ConnectionController@index')->name('connection/index');
Route::get('/connection/technology', 'Home\ConnectionController@technology')->name('connection/technology');
Route::get('/car/index', 'Home\CarController@index')->name('car/index');
// Route::post('/login/loginIn','Home\LoginController@loginIn')->name('login/loginIn');
Route::get('/person/index', 'Home\PersonController@index')->name('person/index');
Route::get('/person/address', 'Home\PersonController@address')->name('person/address');
Route::get('/person/collection', 'Home\PersonController@collection')->name('person/collection');
Route::get('/person/orderDetails', 'Home\PersonController@orderDetails')->name('person/orderDetails');
Route::get('/person/orderManage', 'Home\PersonController@orderManage')->name('person/orderManage');
Route::get('/person/password', 'Home\PersonController@password')->name('person/password');
Route::post('/person/password_do', 'Home\PersonController@password_do')->name('person/password_do');
Route::post('/person/personChange', 'Home\PersonController@personChange')->name('person/personChange');
Route::get('/sale/index', 'Home\SaleController@index')->name('sale/index');
Route::get('/sale/stars', 'Home\SaleController@stars')->name('sale/stars');
Route::get('/question/index', 'Home\QuestionController@index')->name('question/index');

//生成验证码
Route::get('/verification-code', 'Home\InformationController@verificationCode')->name('verification-code');
//保存参与调查用户答案
Route::post('/save-user-answers', 'Home\InformationController@saveUserAnswers')->name('save-user-answers');
//用户调查问卷首页
Route::get('/questionnaire/{id}', 'Home\LoginController@questionnaire')->name('questionnaire');
//保存游客用户信息
Route::post('/register-action', 'Home\LoginController@registerAction')->name('register-action');

// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

// Route::group(['prefix'=>'admin','namespace'=>'Admin'],function (){
// 	Route::get('/','AdminHomeController@index');
// 	Route::resource('pages','PagesController');
// });
// Route::resource('photo','PhotoController');
		
// Route::get('/', function () {
// 	$c = new JdClient();
// 	$c->appKey = "2B8E53069FA43C654FCAC6D00569ECC3";
// 	$c->appSecret = "37dccc2b43ac4f77a681fe9f56bd7d49";
// 	$c->accessToken = "bbf4709d-c404-416f-9bd2-ee01b1b84424";
// 	$c->serverUrl = "http://gw.api.360buy.net/routerjson";
// 	$req = new PopOrderSearchRequest;
// 	$req->setOrderState( "WAIT_SELLER_STOCK_OUT" ); $req->setOptionalFields( "venderId" );  $req->setPage( "1" ); $req->setPageSize( "12" ); 

// 	$resp = $c->execute($req, $c->accessToken);
// 	print(json_encode($resp));
// });
