<?php

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "admin" middleware group. Now create something great!
|
*/

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['administrator', 'localizationRedirect'],
    'as' => 'administrator.' . app()->getLocale() . '.'
], function() {

    Route::group(['prefix' => 'administrator', 'namespace' => 'Minmax\Io\Administrator', 'middleware' => 'auth:administrator'], function () {
        /*
         |--------------------------------------------------------------------------
         | 需要登入的路由。
         |--------------------------------------------------------------------------
         */

        /*
         * IoConstruct 匯入匯出管理
         */
        Route::get('io-construct', 'IoConstructController@index')->name('io-construct.index');
        Route::post('io-construct', 'IoConstructController@store')->name('io-construct.store');
        Route::get('io-construct/create', 'IoConstructController@create')->name('io-construct.create');
        Route::get('io-construct/{id}', 'IoConstructController@show')->name('io-construct.show');
        Route::put('io-construct/{id}', 'IoConstructController@update')->name('io-construct.update');
        Route::delete('io-construct/{id}', 'IoConstructController@destroy')->name('io-construct.destroy');
        Route::get('io-construct/{id}/edit', 'IoConstructController@edit')->name('io-construct.edit');
        Route::post('io-construct/ajax/datatables', 'IoConstructController@ajaxDataTable')->name('io-construct.ajaxDataTable');
        Route::patch('io-construct/ajax/switch', 'IoConstructController@ajaxSwitch')->name('io-construct.ajaxSwitch');
        Route::patch('io-construct/ajax/sort', 'IoConstructController@ajaxSort')->name('io-construct.ajaxSort');

        Route::get('io-construct/{id}/config', 'IoConstructController@config')->name('io-construct.config');
        Route::get('io-construct/{id}/example', 'IoConstructController@example')->name('io-construct.example');
        Route::post('io-construct/{id}/import', 'IoConstructController@import')->name('io-construct.import');
        Route::post('io-construct/{id}/export', 'IoConstructController@export')->name('io-construct.export');

    });

});
