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
        Route::group(['middleware' => 'admin'], function(){
            Route::get('/', 'UserController@index')->name('user.index');
            Route::get('/edit/{user}', 'UserController@edit')->name('user.edit');
            Route::put('/{user}', 'UserController@update')->name('user.update');
            Route::delete('/{user}', 'UserController@delete')->name('user.delete');
        });
        Route::get('/profile', 'UserController@profile')->name('user.profile');
        Route::put('/profile/save', 'UserController@updateProfile')->name('user.update.profile');
        Route::get('/password', 'UserController@password')->name('user.password');
        Route::put('/password/save', 'UserController@updatePassword')->name('user.update.password');
    });
    Route::group(['prefix' => 'schedule'], function(){
        Route::get('/', 'ScheduleController@index')->name('schedule.index');
        Route::get('create', 'ScheduleController@create')->name('schedule.create');
        Route::post('/', 'ScheduleController@store')->name('schedule.store');
        Route::get('/edit/{schedule}', 'ScheduleController@edit')->name('schedule.edit');
        Route::put('/{schedule}', 'ScheduleController@update')->name('schedule.update');
        Route::delete('/{schedule}', 'ScheduleController@delete')->name('schedule.delete');
        Route::get('show/{schedule}', 'ScheduleController@show')->name('schedule.show');
        Route::get('/json', 'ScheduleController@fetchAll')->name('schedule.json');
    });
    Route::group(['prefix' => 'accessories'], function(){
        Route::get('/', 'AccessoriesController@index')->name('accessory.index');
        Route::post('/', 'AccessoriesController@store')->name('accessory.store');
        Route::put('/{accessory}', 'AccessoriesController@update')->name('accessory.update');
        Route::delete('/{accessory}', 'AccessoriesController@delete')->name('accessory.delete');
    });
    Route::group(['prefix' => 'equipments'], function(){
        Route::get('/', 'EquipmentsController@index')->name('equipment.index');
        Route::post('/', 'EquipmentsController@store')->name('equipment.store');
        Route::put('/{equipment}', 'EquipmentsController@update')->name('equipment.update');
        Route::delete('/{equipment}', 'EquipmentsController@delete')->name('equipment.delete');
    });
    Route::group(['prefix' => 'situations'], function(){
        Route::get('/', 'SituationsController@index')->name('situation.index');
        Route::post('/', 'SituationsController@store')->name('situation.store');
        Route::put('/{situation}', 'SituationsController@update')->name('situation.update');
        Route::delete('/{situation}', 'SituationsController@delete')->name('situation.delete');
    });
    Route::group(['prefix' => 'equipment-types'], function(){
        Route::get('/', 'TypesController@index')->name('type.index');
        Route::post('/', 'TypesController@store')->name('type.store');
        Route::put('/{type}', 'TypesController@update')->name('type.update');
        Route::delete('/{type}', 'TypesController@delete')->name('types.delete');
    });
    Route::group(['prefix' => 'movements'], function(){
        Route::get('/', 'MovementsController@index')->name('movement.index');
        Route::post('/', 'MovementsController@store')->name('movement.store');
        Route::put('/{movement}', 'MovementsController@update')->name('movement.update');
        Route::delete('/{movement}', 'MovementsController@delete')->name('movement.delete');
    });
    Route::group(['prefix' => 'service-orders'], function(){
        Route::get('/', 'ServiceOrdersController@index')->name('so.index');
        Route::get('create', 'ServiceOrdersController@create')->name('so.create');
        Route::post('/', 'ServiceOrdersController@store')->name('so.store');
        Route::get('/edit/{so}', 'ServiceOrdersController@edit')->name('so.edit');
        Route::get('/show/{so}', 'ServiceOrdersController@show')->name('so.show');
        Route::put('/{so}', 'ServiceOrdersController@update')->name('so.update');
        Route::delete('/{so}', 'ServiceOrdersController@delete')->name('so.delete');
        Route::post('/status/{so}', 'ServiceOrdersController@status')->name('so.status');
    });

    Route::group(['prefix' => 'budget'], function(){
        Route::get('/', 'BudgetsController@index')->name('budget.index');
        Route::get('create/{call}', 'BudgetsController@create')->name('budget.create');
        Route::post('/', 'BudgetsController@store')->name('budget.store');
        Route::get('/edit/{budget}', 'BudgetsController@edit')->name('budget.edit');
        Route::put('/{budget}', 'BudgetsController@update')->name('budget.update');
        Route::delete('/{budget}', 'BudgetsController@delete')->name('budget.delete');
        Route::get('/show/{budget}', 'BudgetsController@show')->name('budget.show');
    });

});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/chart', 'HomeController@chart')->name('home.chart');
