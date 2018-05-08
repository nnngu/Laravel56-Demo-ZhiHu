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

// Laravel 欢迎页面
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// 留言板的路由
//Route::get('/', 'SignaturesController@index')->name('home');
//Route::get('sign', 'SignaturesController@create')->name('sign');

//Route::any('test', function () {
//    return '哈哈😁，测试成功！';
//});
//
//Route::get('admin', 'Admin\IndexController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('email/verify/{token}', ['as' => 'email.verify', 'uses' => 'EmailController@verify']);

Route::resource('questions', 'QuestionsController');
