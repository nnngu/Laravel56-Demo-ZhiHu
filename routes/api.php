<?php

use App\Article;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// 留言板的路由 start ~~~~~~~~~~~~~~~
//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
//Route::resource('signatures', 'Api\SignatureController')->only(['index', 'store', 'show']);
//Route::put('signatures/{signature}/report', 'Api\ReportSignature@update');
// 留言板的路由 end ~~~~~~~~~~~~~~~



// api_demo 的路由 start -----------------
//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
//
//Route::group(['middleware' => 'auth:api'], function () {
//    Route::get('articles', 'ArticleController@index');
//    Route::get('articles/{article}', 'ArticleController@show');
//    Route::post('articles', 'ArticleController@store');
//    Route::put('articles/{article}', 'ArticleController@update');
//    Route::delete('articles/{article}', 'ArticleController@delete');
//});
//
//Route::post('register', 'Auth\RegisterController@register');
//Route::post('login', 'Auth\LoginController@login')->name('login');
//Route::post('logout', 'Auth\LoginController@logout');
// api_demo 的路由 end -----------------


Route::get('/topics', function(Request $request) {
    $topics = \App\Topic::select(['id', 'name'])->where('name', 'like', '%'.$request->query('q').'%')->get();
    return $topics;
})->middleware('api');