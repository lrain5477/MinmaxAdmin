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
    'prefix' => 'siteadmin',
    'middleware' => 'admin',
    'namespace' => 'Minmax\Base\Admin',
    'name' => 'admin.'
], function() {
    Route::get('test', function() {
        dd('test2');
    });

    // 登入登出
    Route::get('captcha/{name}/{id?}', 'HelperController@getCaptcha')->name('captcha');
    Route::post('login', 'LoginController@login');
    Route::get('login', 'LoginController@showLoginForm')->name('login');
    Route::get('logout', 'LoginController@logout')->name('logout');

    Route::group(['middleware' => 'auth:admin'], function() {

        /*
         |--------------------------------------------------------------------------
         | 需要登入的路由。
         |--------------------------------------------------------------------------
         */

        // 首頁
        Route::get('/', 'SiteController@index')->name('home');

        // 個人資料
        Route::get('profile', 'ProfileController@edit')->name('profile');
        Route::put('profile', 'ProfileController@update');

        // 圖片縮圖
        Route::get('thumbnail/{width}x{height}/{imagePath}', 'HelperController@getThumbnail')->where([
            'width' => config('app.thumbnail_size'),
            'height' => config('app.thumbnail_size'),
            'imagePath' => '.+\.(jpg|png|gif)$'
        ])->name('thumbnail');

        // EditorTemplate
        Route::get('editor/template/{category}.js', 'HelperController@getEditorTemplate')->name('editorTemplate');

        // elFinder
        Route::group(['prefix' => 'elfinder'], function() {
            Route::get('/',  ['as' => 'elfinder.index', 'uses' =>'ElfinderController@showIndex']);
            Route::any('connector', ['as' => 'elfinder.connector', 'uses' => 'ElfinderController@showConnector']);
            Route::get('ckeditor', ['as' => 'elfinder.ckeditor', 'uses' => 'ElfinderController@showCKeditor4']);
        });

        // NewsletterSchedule
        Route::get('newsletter-schedule/ajax/template', 'NewsletterScheduleController@ajaxTemplate')->name('newsletter-schedule.ajax.template');

        // NewsletterSubscribe
        Route::get('newsletter-subscribe/data/export', 'NewsletterSubscribeController@export')->name('newsletter-subscribe.export');
    });
});
