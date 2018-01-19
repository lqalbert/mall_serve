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

Route::get('/', function () {
    return view('welcome');
});

//登录 退出
Route::post('/login', 'LoginController@login');
Route::post('/logout', 'LoginController@out');

Route::get('/categorys/{pid}','CategoryController@getLevels');
Route::resource('/categorys','CategoryController');
Route::get('/tree','CategoryController@getCascade');
Route::resource('/customers','CustomerController');

Route::resource('/orderlist','OrderListController');
Route::resource('/inventorylist','InventoryListController');
Route::resource('/departments','DepartmentController');
Route::resource('/groups','GroupController');
Route::resource('/expressinfo','ExpressInfoController');
Route::post('/upload', 'UploadController@index')->name('upload');
Route::resource('/roles','RoleController');


Route::resource('/goodsdetails','GoodsDetailsController');
Route::resource('/customerinformation','CustomerInformationController');
Route::resource('/departments','DepartmentController');
Route::resource('/orderlists','OrderlistController');
Route::resource('/employees','EmployeeController');
Route::resource('/goodsout','GoodsOutController');
Route::resource('/goodsinto','GoodsIntoController');
Route::resource('/goodsspecs','GoodsSpecsController');
Route::resource('/goodstype','GoodsTypeController');

