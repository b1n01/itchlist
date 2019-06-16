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

// Lists
Route::get('/', 'ListController@list')->name('list');
Route::get('/{uuid}', 'ListController@userList')->name('user.list');

// Auth
Route::get('/auth/join', 'AuthController@loginForm')->name('login.form');
Route::get('/auth/login', 'AuthController@login')->name('login');
Route::get('/auth/confirm', 'AuthController@confirm')->name('confirm');
Route::post('/auth/logout', 'AuthController@logout')->name('logout');

Route::group(['middleware' => 'auth'], function () {

    // Itches
    Route::post('/api/itch', 'ItchController@add')->name('itch.add');
    Route::delete('/api/itch/{id}', 'ItchController@delete')->name('itch.delete');
    Route::post('/api/itch/{id}/book', 'ItchController@book')->name('itch.book');
    Route::post('/api/itch/{id}/unbook', 'ItchController@unbook')->name('itch.unbook');
    Route::post('/api/itch/{id}/show', 'ItchController@toggle')->name('itch.show');
    Route::post('/api/itch/{id}/hide', 'ItchController@toggle')->name('itch.hide');
    
    // Friends
    Route::get('/api/friends', 'FriendsController@friends')->name('friends');

    // Account
    Route::get('/me/account', 'AccountController@account')->name('account');
    Route::delete('/api/me/account', 'AccountController@delete')->name('account.delete');
});