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



Route::middleware(['auth:admin'])->group(function() {
    // 首頁
    Route::get('/', 'SiteController@index')->name('home');

    // 個人資料
    Route::get('profile', 'ProfileController@edit')->name('profile');
    Route::put('profile', 'ProfileController@update');

    // elFinder
    Route::prefix('elfinder')->group(function() {
        Route::get('/',  ['as' => 'elfinder.index', 'uses' =>'CustomElfinderController@showIndex']);
        Route::any('connector', ['as' => 'elfinder.connector', 'uses' => 'CustomElfinderController@showConnector']);
        Route::get('popup/{input_id}', ['as' => 'elfinder.popup', 'uses' => 'CustomElfinderController@showPopup']);
        Route::get('filepicker/{input_id}', ['as' => 'elfinder.filepicker', 'uses' => 'CustomElfinderController@showFilePicker']);
        Route::get('tinymce', ['as' => 'elfinder.tinymce', 'uses' => 'CustomElfinderController@showTinyMCE']);
        Route::get('tinymce4', ['as' => 'elfinder.tinymce4', 'uses' => 'CustomElfinderController@showTinyMCE4']);
        Route::get('ckeditor', ['as' => 'elfinder.ckeditor', 'uses' => 'CustomElfinderController@showCKeditor4']);
    });

    /*
    |--------------------------------------------------------------------------
    | 如果前面沒有特別設定路由，將會走下方 CRUD 自動規則
    | 若是直接繼承 Controller 類別，基本上不需要特別設定路由
    |--------------------------------------------------------------------------
    */

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
