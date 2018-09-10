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

// 登入登出
Route::get('captcha/{name}/{id?}', 'HelperController@getCaptcha')->name('captcha');
Route::post('login', 'LoginController@login');
Route::get('login', 'LoginController@showLoginForm')->name('login');
Route::get('logout', 'LoginController@logout')->name('logout');

Route::group(['middleware' => 'auth:admin'], function() {

    /**
     *--------------------------------------------------------------------------
     * 依系統選單建立 CRUD 自動規則。
     * 若有額外的路由，可以增加於 $actionList 或於下方獨立增加路由。
     *--------------------------------------------------------------------------
     */

    try {
        $prefixNamespace = 'Admin';
        $routeNamespace = "App\\Http\\Controllers\\{$prefixNamespace}";
        $menuList = \App\Models\AdminMenu::query()
            ->whereNotNull('controller')
            ->where('uri', '!=', 'home-' . strtolower($prefixNamespace))
            ->get();
        $actionList = [
            'post ajaxDataTable /ajax/datatables',
            'post ajaxSwitch /ajax/switch',
            'post ajaxMultiSwitch /ajax/switch-multi',
            'post ajaxSort /ajax/sort',
            'get edit /{id}/edit',
            'get create /create',
            'get show /{id}',
            'put update /{id}',
            'delete destroy /{id}',
            'post store ',
            'get index ',
        ];
        foreach ($menuList as $menuItem) {
            if (class_exists("{$routeNamespace}\\{$menuItem->controller}")) {
                foreach ($actionList as $actionItem) {
                    $actionType   = explode(' ', $actionItem)[0] ?? null;
                    $actionMethod = explode(' ', $actionItem)[1] ?? null;
                    $actionUri    = explode(' ', $actionItem)[2] ?? null;
                    if (!is_null($actionType)
                        && !is_null($actionMethod)
                        && !is_null($actionUri)
                        && method_exists("{$routeNamespace}\\{$menuItem->controller}", $actionMethod)) {
                        Route::{$actionType}($menuItem->uri . $actionUri, "{$menuItem->controller}@{$actionMethod}")->name("{$menuItem->uri}.{$actionMethod}");
                    }
                }
            }
        }
    } catch (\Exception $e) {}

    /**
     *--------------------------------------------------------------------------
     * 自訂義路由 / 獨立路由。
     * 此處路由 URI 若有與前方自動化路由重複，則會覆蓋前面。
     *--------------------------------------------------------------------------
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
        Route::get('/',  ['as' => 'elfinder.index', 'uses' =>'CustomElfinderController@showIndex']);
        Route::any('connector', ['as' => 'elfinder.connector', 'uses' => 'CustomElfinderController@showConnector']);
        Route::get('ckeditor', ['as' => 'elfinder.ckeditor', 'uses' => 'CustomElfinderController@showCKeditor4']);
    });
});
