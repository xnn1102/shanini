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


//后台的登录页面
Route::get('admin/login',"Admin\LoginController@login");
Route::post('admin/dologin',"Admin\LoginController@dologin");
Route::any('admin/logout','Admin\LoginController@logout');

//验证码测试
Route::get('captch',"Admin\LoginController@captch");

Route::group(['middleware'=>'login'], function(){
	//后台的首页

	Route::any('/admin/index','Admin\IndexController@index');

   //后台的用户管理
   Route::resource('/admin/user', "Admin\UserController");

   Route::post('/admin/userajax', "Admin\UserController@userajax");

   //修改账号密码
    Route::any('/admin/changepass/{id}','Admin\UserController@changepass');

    Route::any('/admin/rechangepass/{id}', 'Admin\UserController@rechangepass');

    Route::any('/admin/profile', 'Admin\UserController@profile');

    Route::post('/admin/doprofile', 'Admin\UserController@doprofile');


});

//前台的首页 
Route::get('/','Home\IndexController@index');


