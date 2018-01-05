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

Route::resource('/orderlist','OrderListController');
Route::resource('/inventorylist','InventoryListController');
Route::resource('/departments','DepartmentController');
Route::resource('/groups','GroupController');
Route::resource('/expressinfo','ExpressInfoController');
Route::post('/upload', 'UploadController@index')->name('upload');
Route::resource('/cosmetics','CosmeticsController');
Route::resource('/customerinformation','CustomerInformationController');
Route::resource('/employees','EmployeeController');
Route::resource('/goodsout','GoodsOutController');
Route::resource('/goodsinto','GoodsIntoController');
Route::resource('/goodsspecs','GoodsSpecsController');
Route::resource('/goodstype','GoodsTypeController');

