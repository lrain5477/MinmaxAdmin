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
    'namespace' => 'Minmax\Base\Admin',
    'as' => 'admin.' . app()->getLocale() . '.'
], function() {

    Route::group(['prefix' => 'siteadmin'], function () {

        // 登入登出
        Route::get('captcha/{name}/{id?}', 'HelperController@getCaptcha')->name('captcha');
        Route::get('login', 'LoginController@showLoginForm')->name('login');
        Route::post('login', 'LoginController@login');
        Route::get('logout', 'LoginController@logout')->name('logout');

        Route::group(['middleware' => 'auth:admin'], function () {

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
            Route::group(['prefix' => 'elfinder'], function () {
                Route::get('/', ['as' => 'elfinder.index', 'uses' => 'ElfinderController@showIndex']);
                Route::any('connector', ['as' => 'elfinder.connector', 'uses' => 'ElfinderController@showConnector']);
                Route::get('ckeditor', ['as' => 'elfinder.ckeditor', 'uses' => 'ElfinderController@showCKeditor4']);
            });

            /*
             * Firewall 防火牆
             */
            Route::get('firewall', 'FirewallController@index')->name('firewall.index');
            Route::post('firewall', 'FirewallController@store')->name('firewall.store');
            Route::get('firewall/create', 'FirewallController@create')->name('firewall.create');
            Route::get('firewall/{id}', 'FirewallController@show')->name('firewall.show');
            Route::put('firewall/{id}', 'FirewallController@update')->name('firewall.update');
            Route::delete('firewall/{id}', 'FirewallController@destroy')->name('firewall.destroy');
            Route::get('firewall/{id}/edit', 'FirewallController@edit')->name('firewall.edit');
            Route::post('firewall/ajax/datatables', 'FirewallController@ajaxDataTable')->name('firewall.ajaxDataTable');
            Route::patch('firewall/ajax/switch', 'FirewallController@ajaxSwitch')->name('firewall.ajaxSwitch');
            Route::patch('firewall/ajax/sort', 'FirewallController@ajaxSort')->name('firewall.ajaxSort');

            /*
             * Role 帳號群組
             */
            Route::get('role', 'RoleController@index')->name('role.index');
            Route::post('role', 'RoleController@store')->name('role.store');
            Route::get('role/create', 'RoleController@create')->name('role.create');
            Route::get('role/{id}', 'RoleController@show')->name('role.show');
            Route::put('role/{id}', 'RoleController@update')->name('role.update');
            Route::delete('role/{id}', 'RoleController@destroy')->name('role.destroy');
            Route::get('role/{id}/edit', 'RoleController@edit')->name('role.edit');
            Route::post('role/ajax/datatables', 'RoleController@ajaxDataTable')->name('role.ajaxDataTable');
            Route::patch('role/ajax/switch', 'RoleController@ajaxSwitch')->name('role.ajaxSwitch');

        });

    });

});
