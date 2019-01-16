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

    Route::group(['prefix' => 'administrator', 'namespace' => 'Minmax\Notify\Administrator', 'middleware' => 'auth:administrator'], function () {
        /*
         |--------------------------------------------------------------------------
         | 需要登入的路由。
         |--------------------------------------------------------------------------
         */

        /*
         * NotifyEmail 通知信件
         */
        Route::get('notify-email', 'NotifyEmailController@index')->name('notify-email.index');
        Route::post('notify-email', 'NotifyEmailController@store')->name('notify-email.store');
        Route::get('notify-email/create', 'NotifyEmailController@create')->name('notify-email.create');
        Route::get('notify-email/{id}', 'NotifyEmailController@show')->name('notify-email.show');
        Route::put('notify-email/{id}', 'NotifyEmailController@update')->name('notify-email.update');
        Route::delete('notify-email/{id}', 'NotifyEmailController@destroy')->name('notify-email.destroy');
        Route::get('notify-email/{id}/edit', 'NotifyEmailController@edit')->name('notify-email.edit');
        Route::post('notify-email/ajax/datatables', 'NotifyEmailController@ajaxDataTable')->name('notify-email.ajaxDataTable');
        Route::patch('notify-email/ajax/switch', 'NotifyEmailController@ajaxSwitch')->name('notify-email.ajaxSwitch');
        Route::patch('notify-email/ajax/sort', 'NotifyEmailController@ajaxSort')->name('notify-email.ajaxSort');

    });

});
