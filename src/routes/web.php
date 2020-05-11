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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::group(['middleware' => 'auth'], function() {
    
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/praise{auth_user}', 'PraiseController@showPraiseForm')->name('praise.create');
    Route::post('/praise{auth_user}', 'PraiseController@praiseCreate');
    Route::get('/mypage{auth_user}', 'MyPageController@showMyPageForm')->name('mypage');
    Route::get('/mypage/menu-1', 'MyPageController@getMyPraiseList');
    Route::get('/mypage/menu-1/{page}', 'MyPageController@moreGetMyPraiseList');
    Route::get('/mypage/menu-2', 'MyPageController@getToMyPraiseList');
    Route::get('/mypage/menu-2/{page}', 'MyPageController@moreGetToMyPraiseList');
});

