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
Route::get('login/captcha/{id?}', function($id = '') {
    return \App\Helpers\CaptchaHelper::createCaptcha($id, 'adminCaptcha');
})->name('loginCaptcha');
Route::post('login', 'LoginController@login');
Route::get('login', 'LoginController@showLoginForm')->name('login');
Route::get('logout', 'LoginController@logout')->name('logout');

Route::middleware(['auth:admin'])->group(function($route) {
    // 首頁
    Route::get('/', 'SiteController@index')->name('home');

    // 個人資料
    Route::get('profile', 'ProfileController@edit')->name('profile');
    Route::put('profile', 'ProfileController@update');

    // 圖片縮圖
    Route::get('thumbnail/{width}x{height}/{imagePath}', function($width, $height, $imagePath) {
        if($width != $height) abort(404);
        $thumbnailPath = \App\Helpers\ImageHelper::makeThumbnail($imagePath, $width, $height);
        return response(Storage::get($thumbnailPath), 200)->header('Content-Type', Storage::mimeType($thumbnailPath));
    })->where([
        'width' => env('THUMBNAIL_SIZE'),
        'height' => env('THUMBNAIL_SIZE'),
        'imagePath' => '.+\.(jpg|png|gif)$'
    ])->name('thumbnail');

    // elFinder
    Route::prefix('elfinder')->group(function() {
        Route::get('/',  ['as' => 'elfinder.index', 'uses' =>'CustomElfinderController@showIndex']);
        Route::any('connector', ['as' => 'elfinder.connector', 'uses' => 'CustomElfinderController@showConnector']);
        Route::get('ckeditor', ['as' => 'elfinder.ckeditor', 'uses' => 'CustomElfinderController@showCKeditor4']);
    });

    /*
    |--------------------------------------------------------------------------
    | 如果前面沒有特別設定路由，將會走下方 CRUD 自動規則
    | 若是直接繼承 Controller 類別，基本上不需要特別設定路由
    |--------------------------------------------------------------------------
    */

    // 指定 CRUD 路由
    foreach(\App\Models\AdminMenuItem::all() as $menuItem) {
        if(!is_null($menuItem->controller) && class_exists("App\\Http\\Controllers\\Admin\\{$menuItem->controller}")) {
            if(method_exists("App\\Http\\Controllers\\Admin\\{$menuItem->controller}", 'ajaxDataTable')) {
                Route::post($menuItem->uri . '/ajax/datatables', "{$menuItem->controller}@ajaxDataTable");
            }
            if(method_exists("App\\Http\\Controllers\\Admin\\{$menuItem->controller}", 'ajaxSwitch')) {
                Route::post($menuItem->uri . '/ajax/switch', "{$menuItem->controller}@ajaxSwitch");
            }
            if(method_exists("App\\Http\\Controllers\\Admin\\{$menuItem->controller}", 'ajaxMultiSwitch')) {
                Route::post($menuItem->uri . '/ajax/switch-multi', "{$menuItem->controller}@ajaxMultiSwitch");
            }
            if(method_exists("App\\Http\\Controllers\\Admin\\{$menuItem->controller}", 'ajaxSort')) {
                Route::post($menuItem->uri . '/ajax/sort', "{$menuItem->controller}@ajaxSort");
            }
            if(method_exists("App\\Http\\Controllers\\Admin\\{$menuItem->controller}", 'edit')) {
                Route::post($menuItem->uri . '/{id}/edit', "{$menuItem->controller}@edit");
            }
            if(method_exists("App\\Http\\Controllers\\Admin\\{$menuItem->controller}", 'edit')) {
                Route::get($menuItem->uri . '/{id}/edit', "{$menuItem->controller}@edit");
            }
            if(method_exists("App\\Http\\Controllers\\Admin\\{$menuItem->controller}", 'create')) {
                Route::get($menuItem->uri . '/create', "{$menuItem->controller}@create");
            }
            if(method_exists("App\\Http\\Controllers\\Admin\\{$menuItem->controller}", 'show')) {
                Route::get($menuItem->uri . '/{id}', "{$menuItem->controller}@show");
            }
            if(method_exists("App\\Http\\Controllers\\Admin\\{$menuItem->controller}", 'update')) {
                Route::put($menuItem->uri . '/{id}', "{$menuItem->controller}@update");
            }
            if(method_exists("App\\Http\\Controllers\\Admin\\{$menuItem->controller}", 'destroy')) {
                Route::delete($menuItem->uri . '/{id}', "{$menuItem->controller}@destroy");
            }
            if(method_exists("App\\Http\\Controllers\\Admin\\{$menuItem->controller}", 'store')) {
                Route::post($menuItem->uri, "{$menuItem->controller}@store");
            }
            if(method_exists("App\\Http\\Controllers\\Admin\\{$menuItem->controller}", 'index')) {
                Route::get($menuItem->uri, "{$menuItem->controller}@index");
            }
        }
    }

    // 基本 CRUD 路由
    Route::post('{uri}/ajax/datatables', 'Controller@ajaxDataTable')->name('datatables');
    Route::post('{uri}/ajax/switch', 'Controller@ajaxSwitch')->name('switch');
    Route::post('{uri}/ajax/switch-multi', 'Controller@ajaxMultiSwitch')->name('multiSwitch');
    Route::post('{uri}/ajax/sort', 'Controller@ajaxSort')->name('sort');
    Route::get('{uri}/{id}/edit', 'Controller@edit')->name('edit');
    Route::get('{uri}/create', 'Controller@create')->name('create');
    Route::get('{uri}/{id}', 'Controller@show')->name('show');
    Route::put('{uri}/{id}', 'Controller@update')->name('update');
    Route::delete('{uri}/{id}', 'Controller@destroy')->name('destroy');
    Route::post('{uri}', 'Controller@store')->name('store');
    Route::get('{uri}', 'Controller@index')->name('index');
});
