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
    'middleware' => ['admin', 'localizationRedirect'],
    'as' => 'admin.' . app()->getLocale() . '.'
], function() {

    Route::group(['prefix' => 'siteadmin', 'namespace' => 'Minmax\Io\Admin', 'middleware' => 'auth:admin'], function () {
        /*
         |--------------------------------------------------------------------------
         | 需要登入的路由。
         |--------------------------------------------------------------------------
         */

        /*
         * IoConstruct 匯入匯出
         */
        Route::get('io-data', 'IoConstructController@index')->name('io-data.index');
        Route::post('io-data/ajax/datatables', 'IoConstructController@ajaxDataTable')->name('io-data.ajaxDataTable');

        Route::get('io-data/{id}/config', 'IoConstructController@config')->name('io-data.config');
        Route::get('io-data/{id}/example', 'IoConstructController@example')->name('io-data.example');
        Route::post('io-data/{id}/import', 'IoConstructController@import')->name('io-data.import');
        Route::post('io-data/{id}/export', 'IoConstructController@export')->name('io-data.export');

    });

});
