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

Route::resource('/cosmetics','CosmeticsController');
Route::resource('/customerinformation','CustomerInformationController');
Route::resource('/departments','DepartmentController');
Route::resource('/employee','EmployeeController');
Route::resource('/goodsout','GoodsOutController');
Route::resource('/groups','GroupController');