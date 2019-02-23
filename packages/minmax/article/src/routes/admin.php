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
    'as' => 'admin.' . app()->getLocale() . '.'
], function() {

    Route::group(['prefix' => 'siteadmin', 'namespace' => 'Minmax\Article\Admin', 'middleware' => 'auth:admin'], function () {
        /*
         |--------------------------------------------------------------------------
         | 需要登入的路由。
         |--------------------------------------------------------------------------
         */

        /*
         * ArticleNews 新聞稿
         */
        Route::get('article-news', 'ArticleNewsController@index')->name('article-news.index');
        Route::post('article-news', 'ArticleNewsController@store')->name('article-news.store');
        Route::get('article-news/create', 'ArticleNewsController@create')->name('article-news.create');
        Route::get('article-news/{id}', 'ArticleNewsController@show')->name('article-news.show');
        Route::put('article-news/{id}', 'ArticleNewsController@update')->name('article-news.update');
        Route::delete('article-news/{id}', 'ArticleNewsController@destroy')->name('article-news.destroy');
        Route::get('article-news/{id}/edit', 'ArticleNewsController@edit')->name('article-news.edit');
        Route::post('article-news/ajax/datatables', 'ArticleNewsController@ajaxDataTable')->name('article-news.ajaxDataTable');
        Route::patch('article-news/ajax/switch', 'ArticleNewsController@ajaxSwitch')->name('article-news.ajaxSwitch');
        Route::patch('article-news/ajax/sort', 'ArticleNewsController@ajaxSort')->name('article-news.ajaxSort');
        Route::patch('article-news/ajax/multi/switch', 'ArticleNewsController@ajaxMultiSwitch')->name('article-news.ajaxMultiSwitch');
        Route::delete('article-news/ajax/multi/delete', 'ArticleNewsController@ajaxMultiDestroy')->name('article-news.ajaxMultiDestroy');

        /*
         * ArticleCategory 內容類別管理
         */
        Route::get('article-category', 'ArticleCategoryController@index')->name('article-category.index');
        Route::post('article-category', 'ArticleCategoryController@store')->name('article-category.store');
        Route::get('article-category/create', 'ArticleCategoryController@create')->name('article-category.create');
        Route::get('article-category/{id}', 'ArticleCategoryController@show')->name('article-category.show');
        Route::put('article-category/{id}', 'ArticleCategoryController@update')->name('article-category.update');
        Route::delete('article-category/{id}', 'ArticleCategoryController@destroy')->name('article-category.destroy');
        Route::get('article-category/{id}/edit', 'ArticleCategoryController@edit')->name('article-category.edit');
        Route::post('article-category/ajax/datatables', 'ArticleCategoryController@ajaxDataTable')->name('article-category.ajaxDataTable');
        Route::patch('article-category/ajax/switch', 'ArticleCategoryController@ajaxSwitch')->name('article-category.ajaxSwitch');
        Route::patch('article-category/ajax/sort', 'ArticleCategoryController@ajaxSort')->name('article-category.ajaxSort');

    });

});
