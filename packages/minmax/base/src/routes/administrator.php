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
    'namespace' => 'Minmax\Base\Administrator',
    'as' => 'administrator.' . app()->getLocale() . '.'
], function() {

    Route::group(['prefix' => 'administrator'], function () {

        // 登入登出
        Route::get('captcha/{name}/{id?}', 'HelperController@getCaptcha')->name('captcha');
        Route::get('login', 'LoginController@showLoginForm')->name('login');
        Route::post('login', 'LoginController@login');
        Route::get('logout', 'LoginController@logout')->name('logout');

        Route::group(['middleware' => 'auth:administrator'], function () {

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
            Route::get('web-data', 'WebDataController@index')->name('web-data.index');
            Route::post('web-data', 'WebDataController@store')->name('web-data.store');
            Route::get('web-data/create', 'WebDataController@create')->name('web-data.create');
            Route::get('web-data/{id}', 'WebDataController@show')->name('web-data.show');
            Route::put('web-data/{id}', 'WebDataController@update')->name('web-data.update');
            Route::delete('web-data/{id}', 'WebDataController@destroy')->name('web-data.destroy');
            Route::get('web-data/{id}/edit', 'WebDataController@edit')->name('web-data.edit');
            Route::post('web-data/ajax/datatables', 'WebDataController@ajaxDataTable')->name('web-data.ajaxDataTable');
            Route::patch('web-data/ajax/switch', 'WebDataController@ajaxSwitch')->name('web-data.ajaxSwitch');
            Route::patch('web-data/ajax/sort', 'WebDataController@ajaxSort')->name('web-data.ajaxSort');

            /*
             * AdminMenu 後臺選單管理
             */
            Route::get('admin-menu', 'AdminMenuController@index')->name('admin-menu.index');
            Route::post('admin-menu', 'AdminMenuController@store')->name('admin-menu.store');
            Route::get('admin-menu/create', 'AdminMenuController@create')->name('admin-menu.create');
            Route::get('admin-menu/{id}', 'AdminMenuController@show')->name('admin-menu.show');
            Route::put('admin-menu/{id}', 'AdminMenuController@update')->name('admin-menu.update');
            Route::delete('admin-menu/{id}', 'AdminMenuController@destroy')->name('admin-menu.destroy');
            Route::get('admin-menu/{id}/edit', 'AdminMenuController@edit')->name('admin-menu.edit');
            Route::post('admin-menu/ajax/datatables', 'AdminMenuController@ajaxDataTable')->name('admin-menu.ajaxDataTable');
            Route::patch('admin-menu/ajax/switch', 'AdminMenuController@ajaxSwitch')->name('admin-menu.ajaxSwitch');
            Route::patch('admin-menu/ajax/sort', 'AdminMenuController@ajaxSort')->name('admin-menu.ajaxSort');

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
             * Role 權限角色管理
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
             * Role 權限物件管理
             */
            Route::get('permission', 'PermissionController@index')->name('permission.index');
            Route::post('permission', 'PermissionController@store')->name('permission.store');
            Route::get('permission/create', 'PermissionController@create')->name('permission.create');
            Route::get('permission/{id}', 'PermissionController@show')->name('permission.show');
            Route::put('permission/{id}', 'PermissionController@update')->name('permission.update');
            Route::delete('permission/{id}', 'PermissionController@destroy')->name('permission.destroy');
            Route::get('permission/{id}/edit', 'PermissionController@edit')->name('permission.edit');
            Route::post('permission/ajax/datatables', 'PermissionController@ajaxDataTable')->name('permission.ajaxDataTable');
            Route::patch('permission/ajax/switch', 'PermissionController@ajaxSwitch')->name('permission.ajaxSwitch');
            Route::patch('permission/ajax/sort', 'PermissionController@ajaxSort')->name('permission.ajaxSort');

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

            /*
             * SystemParameterGroup 系統參數群組
             */
            Route::get('system-parameter-group', 'SystemParameterGroupController@index')->name('system-parameter-group.index');
            Route::post('system-parameter-group', 'SystemParameterGroupController@store')->name('system-parameter-group.store');
            Route::get('system-parameter-group/create', 'SystemParameterGroupController@create')->name('system-parameter-group.create');
            Route::get('system-parameter-group/{id}', 'SystemParameterGroupController@show')->name('system-parameter-group.show');
            Route::put('system-parameter-group/{id}', 'SystemParameterGroupController@update')->name('system-parameter-group.update');
            Route::delete('system-parameter-group/{id}', 'SystemParameterGroupController@destroy')->name('system-parameter-group.destroy');
            Route::get('system-parameter-group/{id}/edit', 'SystemParameterGroupController@edit')->name('system-parameter-group.edit');
            Route::post('system-parameter-group/ajax/datatables', 'SystemParameterGroupController@ajaxDataTable')->name('system-parameter-group.ajaxDataTable');
            Route::patch('system-parameter-group/ajax/switch', 'SystemParameterGroupController@ajaxSwitch')->name('system-parameter-group.ajaxSwitch');
            Route::patch('system-parameter-group/ajax/sort', 'SystemParameterGroupController@ajaxSort')->name('system-parameter-group.ajaxSort');

            /*
             * SystemParameterItem 系統參數項目
             */
            Route::get('system-parameter-item', 'SystemParameterItemController@index')->name('system-parameter-item.index');
            Route::post('system-parameter-item', 'SystemParameterItemController@store')->name('system-parameter-item.store');
            Route::get('system-parameter-item/create', 'SystemParameterItemController@create')->name('system-parameter-item.create');
            Route::get('system-parameter-item/{id}', 'SystemParameterItemController@show')->name('system-parameter-item.show');
            Route::put('system-parameter-item/{id}', 'SystemParameterItemController@update')->name('system-parameter-item.update');
            Route::delete('system-parameter-item/{id}', 'SystemParameterItemController@destroy')->name('system-parameter-item.destroy');
            Route::get('system-parameter-item/{id}/edit', 'SystemParameterItemController@edit')->name('system-parameter-item.edit');
            Route::post('system-parameter-item/ajax/datatables', 'SystemParameterItemController@ajaxDataTable')->name('system-parameter-item.ajaxDataTable');
            Route::patch('system-parameter-item/ajax/switch', 'SystemParameterItemController@ajaxSwitch')->name('system-parameter-item.ajaxSwitch');
            Route::patch('system-parameter-item/ajax/sort', 'SystemParameterItemController@ajaxSort')->name('system-parameter-item.ajaxSort');

            /*
             * EditorTemplate 編輯器模板管理
             */
            Route::get('editor-template', 'EditorTemplateController@index')->name('editor-template.index');
            Route::post('editor-template', 'EditorTemplateController@store')->name('editor-template.store');
            Route::get('editor-template/create', 'EditorTemplateController@create')->name('editor-template.create');
            Route::get('editor-template/{id}', 'EditorTemplateController@show')->name('editor-template.show');
            Route::put('editor-template/{id}', 'EditorTemplateController@update')->name('editor-template.update');
            Route::delete('editor-template/{id}', 'EditorTemplateController@destroy')->name('editor-template.destroy');
            Route::get('editor-template/{id}/edit', 'EditorTemplateController@edit')->name('editor-template.edit');
            Route::post('editor-template/ajax/datatables', 'EditorTemplateController@ajaxDataTable')->name('editor-template.ajaxDataTable');
            Route::patch('editor-template/ajax/switch', 'EditorTemplateController@ajaxSwitch')->name('editor-template.ajaxSwitch');
            Route::patch('editor-template/ajax/sort', 'EditorTemplateController@ajaxSort')->name('editor-template.ajaxSort');

        });

    });

});
