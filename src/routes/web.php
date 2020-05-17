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
    Route::get('/mypage/chart', 'MyPageController@showChart');
    Route::get('/mypage/diagram', 'MyPageController@showdiagram');
    Route::post('/mypage/profile', 'MyPageController@EditProfile')->name('mypage.edit');
    Route::get('/comments/{board_id}', 'HomeController@showCommentList')->name('comment');//コメント表示機能
    Route::post('/comments/{board_id}', 'HomeController@postComment');//コメント投稿
    Route::post('/goods/{board_id}', 'HomeController@postGood')->name('good');//いいね投稿

});

