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
//主页路由
Route::get('/', 'Web\AppController@getApp')->middleware('auth');
//登录页面路由
Route::get('/login','Web\AuthenticationController@getLogin')->name('login')->middleware('guest');
//跳转第三方用户验证的OAuth的路由
Route::get('/auth/{social}','Web\AuthenticationController@getSocialRedirect')->middleware('guest');
//跳转第三方用户验证的回调路由
Route::get('/auth/{social}/callback','Web\AuthenticationController@getSocialCallback')->middleware('guest');

Route::get('/test/{id}','API\CafesController@getCafe');