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
    return redirect('/home');
});

Route::middleware(['auth'])->group(function(){
    Route::group(['prefix'=>'customer'], function(){
        Route::get('/', 'CustomerController@index')->name('customer.index');
        Route::get('create', 'CustomerController@create')->name('customer.create');
        Route::post('/', 'CustomerController@store')->name('customer.store');
        Route::get('edit/{customer}', 'CustomerController@edit')->name('customer.edit');
        Route::put('/{customer}', 'CustomerController@update')->name('customer.update');
        Route::delete('/{customer}', 'CustomerController@delete')->name('customer.delete');
        Route::get('search', 'CustomerController@search')->name('customer.search');
    });
    Route::group(['prefix'=>'call'], function(){
        Route::get('/', 'CallController@index')->name('call.index');
        Route::get('/fetchall', 'CallController@fetchAll')->name('call.fetchall');
        Route::get('for-you', 'CallController@forYou')->name('call.foryou');
        Route::get('create', 'CallController@create')->name('call.create');
        Route::post('/', 'CallController@store')->name('call.store');
        Route::delete('/{call}', 'CallController@delete')->name('call.delete');
        Route::post('/close/{call}', 'CallController@close')->name('call.close');
        Route::get('/show/{call}', 'CallController@show')->name('call.show');
        Route::post('comment/{call}', 'CommentController@store')->name('comment.store');
        Route::delete('comment/{comment}', 'CommentController@delete')->name('comment.delete');
    });
    Route::group(['prefix' => 'user'], function(){
        Route::get('/', 'UserController@index')->name('user.index');
        Route::get('/profile', 'UserController@profile')->name('user.profile');
        Route::put('/{user}', 'UserController@update')->name('user.update');
        Route::delete('/{user}', 'UserController@delete')->name('user.delete');
    });
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
