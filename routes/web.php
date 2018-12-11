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
        Route::post('search', 'CustomerController@search')->name('customer.search');
    });
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
