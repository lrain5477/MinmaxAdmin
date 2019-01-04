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

            // 圖片縮圖
            Route::get('thumbnail/{width}x{height}/{imagePath}', 'HelperController@getThumbnail')
                ->where([
                    'width' => config('app.thumbnail_size'),
                    'height' => config('app.thumbnail_size'),
                    'imagePath' => '.+\.(jpg|png|gif)$'
                ])
                ->name('thumbnail');

            // EditorTemplate
            Route::get('editor/template/{category}.js', 'HelperController@getEditorTemplate')->name('editorTemplate');

            // elFinder
            Route::get('elfinder', 'ElfinderController@showIndex')->name('elfinder.index');
            Route::get('elfinder/ckeditor', 'ElfinderController@showCKeditor4')->name('elfinder.ckeditor');
            Route::any('elfinder/connector', 'ElfinderController@showConnector')->name('elfinder.connector');

            // 切換表單語系
            Route::put('form/local/set', 'HelperController@setFormLocal')->name('setFormLocal');

            // 個人資料
            Route::get('profile', 'ProfileController@edit')->name('profile');
            Route::put('profile', 'ProfileController@update');

            /*
             * FileManager 檔案總管
             */
            Route::get('file-manager', 'FileManagerController@index')->name('file-manager.index');

            /*
             * WebData 網站基本資訊
             */
            Route::put('web-data/{id}', 'WebDataController@update')->name('web-data.update');
            Route::get('web-data/{id}/edit', 'WebDataController@edit')->name('web-data.edit');

            /*
             * WebMenu 前臺選單管理
             */
            Route::get('web-menu', 'WebMenuController@index')->name('web-menu.index');
            Route::post('web-menu', 'WebMenuController@store')->name('web-menu.store');
            Route::get('web-menu/create', 'WebMenuController@create')->name('web-menu.create');
            Route::get('web-menu/{id}', 'WebMenuController@show')->name('web-menu.show');
            Route::put('web-menu/{id}', 'WebMenuController@update')->name('web-menu.update');
            Route::delete('web-menu/{id}', 'WebMenuController@destroy')->name('web-menu.destroy');
            Route::get('web-menu/{id}/edit', 'WebMenuController@edit')->name('web-menu.edit');
            Route::post('web-menu/ajax/datatables', 'WebMenuController@ajaxDataTable')->name('web-menu.ajaxDataTable');
            Route::patch('web-menu/ajax/switch', 'WebMenuController@ajaxSwitch')->name('web-menu.ajaxSwitch');
            Route::patch('web-menu/ajax/sort', 'WebMenuController@ajaxSort')->name('web-menu.ajaxSort');

            /*
             * Admin 帳號管理
             */
            Route::get('admin', 'AdminController@index')->name('admin.index');
            Route::post('admin', 'AdminController@store')->name('admin.store');
            Route::get('admin/create', 'AdminController@create')->name('admin.create');
            Route::get('admin/{id}', 'AdminController@show')->name('admin.show');
            Route::put('admin/{id}', 'AdminController@update')->name('admin.update');
            Route::delete('admin/{id}', 'AdminController@destroy')->name('admin.destroy');
            Route::get('admin/{id}/edit', 'AdminController@edit')->name('admin.edit');
            Route::post('admin/ajax/datatables', 'AdminController@ajaxDataTable')->name('admin.ajaxDataTable');
            Route::patch('admin/ajax/switch', 'AdminController@ajaxSwitch')->name('admin.ajaxSwitch');
            Route::patch('admin/ajax/sort', 'AdminController@ajaxSort')->name('admin.ajaxSort');

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
             * SystemLog 操作紀錄
             */
            Route::get('system-log', 'SystemLogController@index')->name('system-log.index');
            Route::post('system-log/ajax/datatables', 'SystemLogController@ajaxDataTable')->name('system-log.ajaxDataTable');

            /*
             * LoginLog 登入紀錄
             */
            Route::get('login-log', 'LoginLogController@index')->name('login-log.index');
            Route::post('login-log/ajax/datatables', 'LoginLogController@ajaxDataTable')->name('login-log.ajaxDataTable');

            /*
             * SiteParameterGroup 參數群組
             */
            Route::get('site-parameter-group', 'SiteParameterGroupController@index')->name('site-parameter-group.index');
            Route::post('site-parameter-group', 'SiteParameterGroupController@store')->name('site-parameter-group.store');
            Route::get('site-parameter-group/create', 'SiteParameterGroupController@create')->name('site-parameter-group.create');
            Route::get('site-parameter-group/{id}', 'SiteParameterGroupController@show')->name('site-parameter-group.show');
            Route::put('site-parameter-group/{id}', 'SiteParameterGroupController@update')->name('site-parameter-group.update');
            Route::delete('site-parameter-group/{id}', 'SiteParameterGroupController@destroy')->name('site-parameter-group.destroy');
            Route::get('site-parameter-group/{id}/edit', 'SiteParameterGroupController@edit')->name('site-parameter-group.edit');
            Route::post('site-parameter-group/ajax/datatables', 'SiteParameterGroupController@ajaxDataTable')->name('site-parameter-group.ajaxDataTable');
            Route::patch('site-parameter-group/ajax/switch', 'SiteParameterGroupController@ajaxSwitch')->name('site-parameter-group.ajaxSwitch');
            Route::patch('site-parameter-group/ajax/sort', 'SiteParameterGroupController@ajaxSort')->name('site-parameter-group.ajaxSort');

            /*
             * SiteParameterItem 參數項目
             */
            Route::get('site-parameter-item', 'SiteParameterItemController@index')->name('site-parameter-item.index');
            Route::post('site-parameter-item', 'SiteParameterItemController@store')->name('site-parameter-item.store');
            Route::get('site-parameter-item/create', 'SiteParameterItemController@create')->name('site-parameter-item.create');
            Route::get('site-parameter-item/{id}', 'SiteParameterItemController@show')->name('site-parameter-item.show');
            Route::put('site-parameter-item/{id}', 'SiteParameterItemController@update')->name('site-parameter-item.update');
            Route::delete('site-parameter-item/{id}', 'SiteParameterItemController@destroy')->name('site-parameter-item.destroy');
            Route::get('site-parameter-item/{id}/edit', 'SiteParameterItemController@edit')->name('site-parameter-item.edit');
            Route::post('site-parameter-item/ajax/datatables', 'SiteParameterItemController@ajaxDataTable')->name('site-parameter-item.ajaxDataTable');
            Route::patch('site-parameter-item/ajax/switch', 'SiteParameterItemController@ajaxSwitch')->name('site-parameter-item.ajaxSwitch');
            Route::patch('site-parameter-item/ajax/sort', 'SiteParameterItemController@ajaxSort')->name('site-parameter-item.ajaxSort');

        });

    });

});
