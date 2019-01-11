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

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['web', 'localizationRedirect'],
    'namespace' => 'Minmax\Base\Web',
    'as' => 'web.' . app()->getLocale() . '.'
], function() {

    Route::get('/', 'SiteController@index')->name('home');

    Route::get('captcha/{name}/{id?}', 'HelperController@getCaptcha')->name('captcha');

});