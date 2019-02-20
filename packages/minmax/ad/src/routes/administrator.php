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

    Route::group(['prefix' => 'administrator', 'namespace' => 'Minmax\Ad\Administrator', 'middleware' => 'auth:administrator'], function () {
        /*
         |--------------------------------------------------------------------------
         | 需要登入的路由。
         |--------------------------------------------------------------------------
         */

        /*
         * Advertising 廣告管理
         */
        Route::get('advertising', 'AdvertisingController@index')->name('advertising.index');
        Route::post('advertising', 'AdvertisingController@store')->name('advertising.store');
        Route::get('advertising/create', 'AdvertisingController@create')->name('advertising.create');
        Route::get('advertising/{id}', 'AdvertisingController@show')->name('advertising.show');
        Route::put('advertising/{id}', 'AdvertisingController@update')->name('advertising.update');
        Route::delete('advertising/{id}', 'AdvertisingController@destroy')->name('advertising.destroy');
        Route::get('advertising/{id}/edit', 'AdvertisingController@edit')->name('advertising.edit');
        Route::post('advertising/ajax/datatables', 'AdvertisingController@ajaxDataTable')->name('advertising.ajaxDataTable');
        Route::patch('advertising/ajax/switch', 'AdvertisingController@ajaxSwitch')->name('advertising.ajaxSwitch');
        Route::patch('advertising/ajax/sort', 'AdvertisingController@ajaxSort')->name('advertising.ajaxSort');
        Route::patch('advertising/ajax/multi/switch', 'AdvertisingController@ajaxMultiSwitch')->name('advertising.ajaxMultiSwitch');
        Route::delete('advertising/ajax/multi/delete', 'AdvertisingController@ajaxMultiDestroy')->name('advertising.ajaxMultiDestroy');

        /*
         * AdvertisingCategory 廣告版位
         */
        Route::get('advertising-category', 'AdvertisingCategoryController@index')->name('advertising-category.index');
        Route::post('advertising-category', 'AdvertisingCategoryController@store')->name('advertising-category.store');
        Route::get('advertising-category/create', 'AdvertisingCategoryController@create')->name('advertising-category.create');
        Route::get('advertising-category/{id}', 'AdvertisingCategoryController@show')->name('advertising-category.show');
        Route::put('advertising-category/{id}', 'AdvertisingCategoryController@update')->name('advertising-category.update');
        Route::delete('advertising-category/{id}', 'AdvertisingCategoryController@destroy')->name('advertising-category.destroy');
        Route::get('advertising-category/{id}/edit', 'AdvertisingCategoryController@edit')->name('advertising-category.edit');
        Route::post('advertising-category/ajax/datatables', 'AdvertisingCategoryController@ajaxDataTable')->name('advertising-category.ajaxDataTable');
        Route::patch('advertising-category/ajax/switch', 'AdvertisingCategoryController@ajaxSwitch')->name('advertising-category.ajaxSwitch');
        Route::patch('advertising-category/ajax/sort', 'AdvertisingCategoryController@ajaxSort')->name('advertising-category.ajaxSort');

    });

});
