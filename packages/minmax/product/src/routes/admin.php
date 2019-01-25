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

    Route::group(['prefix' => 'siteadmin', 'namespace' => 'Minmax\Product\Admin', 'middleware' => 'auth:admin'], function () {
        /*
         |--------------------------------------------------------------------------
         | 需要登入的路由。
         |--------------------------------------------------------------------------
         */

        /*
         * ProductItem 品項管理
         */
        Route::get('product-item', 'ProductItemController@index')->name('product-item.index');
        Route::post('product-item', 'ProductItemController@store')->name('product-item.store');
        Route::get('product-item/create', 'ProductItemController@create')->name('product-item.create');
        Route::get('product-item/{id}', 'ProductItemController@show')->name('product-item.show');
        Route::put('product-item/{id}', 'ProductItemController@update')->name('product-item.update');
        Route::delete('product-item/{id}', 'ProductItemController@destroy')->name('product-item.destroy');
        Route::get('product-item/{id}/edit', 'ProductItemController@edit')->name('product-item.edit');
        Route::post('product-item/ajax/datatables', 'ProductItemController@ajaxDataTable')->name('product-item.ajaxDataTable');
        Route::patch('product-item/ajax/switch', 'ProductItemController@ajaxSwitch')->name('product-item.ajaxSwitch');
        Route::patch('product-item/ajax/sort', 'ProductItemController@ajaxSort')->name('product-item.ajaxSort');

        /*
         * ProductCategory 商品分類
         */
        Route::get('product-category', 'ProductCategoryController@index')->name('product-category.index');
        Route::post('product-category', 'ProductCategoryController@store')->name('product-category.store');
        Route::get('product-category/create', 'ProductCategoryController@create')->name('product-category.create');
        Route::get('product-category/{id}', 'ProductCategoryController@show')->name('product-category.show');
        Route::put('product-category/{id}', 'ProductCategoryController@update')->name('product-category.update');
        Route::delete('product-category/{id}', 'ProductCategoryController@destroy')->name('product-category.destroy');
        Route::get('product-category/{id}/edit', 'ProductCategoryController@edit')->name('product-category.edit');
        Route::post('product-category/ajax/datatables', 'ProductCategoryController@ajaxDataTable')->name('product-category.ajaxDataTable');
        Route::patch('product-category/ajax/switch', 'ProductCategoryController@ajaxSwitch')->name('product-category.ajaxSwitch');
        Route::patch('product-category/ajax/sort', 'ProductCategoryController@ajaxSort')->name('product-category.ajaxSort');

        /*
         * ProductBrand 品牌管理
         */
        Route::get('product-brand', 'ProductBrandController@index')->name('product-brand.index');
        Route::post('product-brand', 'ProductBrandController@store')->name('product-brand.store');
        Route::get('product-brand/create', 'ProductBrandController@create')->name('product-brand.create');
        Route::get('product-brand/{id}', 'ProductBrandController@show')->name('product-brand.show');
        Route::put('product-brand/{id}', 'ProductBrandController@update')->name('product-brand.update');
        Route::delete('product-brand/{id}', 'ProductBrandController@destroy')->name('product-brand.destroy');
        Route::get('product-brand/{id}/edit', 'ProductBrandController@edit')->name('product-brand.edit');
        Route::post('product-brand/ajax/datatables', 'ProductBrandController@ajaxDataTable')->name('product-brand.ajaxDataTable');
        Route::patch('product-brand/ajax/switch', 'ProductBrandController@ajaxSwitch')->name('product-brand.ajaxSwitch');
        Route::patch('product-brand/ajax/sort', 'ProductBrandController@ajaxSort')->name('product-brand.ajaxSort');

        /*
         * ProductMarket 賣場管理
         */
        Route::get('product-market', 'ProductMarketController@index')->name('product-market.index');
        Route::post('product-market', 'ProductMarketController@store')->name('product-market.store');
        Route::get('product-market/create', 'ProductMarketController@create')->name('product-market.create');
        Route::get('product-market/{id}', 'ProductMarketController@show')->name('product-market.show');
        Route::put('product-market/{id}', 'ProductMarketController@update')->name('product-market.update');
        Route::delete('product-market/{id}', 'ProductMarketController@destroy')->name('product-market.destroy');
        Route::get('product-market/{id}/edit', 'ProductMarketController@edit')->name('product-market.edit');
        Route::post('product-market/ajax/datatables', 'ProductMarketController@ajaxDataTable')->name('product-market.ajaxDataTable');
        Route::patch('product-market/ajax/switch', 'ProductMarketController@ajaxSwitch')->name('product-market.ajaxSwitch');
        Route::patch('product-market/ajax/sort', 'ProductMarketController@ajaxSort')->name('product-market.ajaxSort');

        /*
         * MemberTerm 會員條款
         */
//        Route::get('member-term', 'MemberTermController@index')->name('member-term.index');
//        Route::post('member-term', 'MemberTermController@store')->name('member-term.store');
//        Route::get('member-term/create', 'MemberTermController@create')->name('member-term.create');
//        Route::get('member-term/{id}', 'MemberTermController@show')->name('member-term.show');
//        Route::put('member-term/{id}', 'MemberTermController@update')->name('member-term.update');
//        Route::delete('member-term/{id}', 'MemberTermController@destroy')->name('member-term.destroy');
//        Route::get('member-term/{id}/edit', 'MemberTermController@edit')->name('member-term.edit');
//        Route::post('member-term/ajax/datatables', 'MemberTermController@ajaxDataTable')->name('member-term.ajaxDataTable');
//        Route::patch('member-term/ajax/switch', 'MemberTermController@ajaxSwitch')->name('member-term.ajaxSwitch');
//        Route::patch('member-term/ajax/sort', 'MemberTermController@ajaxSort')->name('member-term.ajaxSort');
//        Route::patch('member-term/ajax/multi/switch', 'MemberTermController@ajaxMultiSwitch')->name('member-term.ajaxMultiSwitch');
//        Route::delete('member-term/ajax/multi/delete', 'MemberTermController@ajaxMultiDestroy')->name('member-term.ajaxMultiDestroy');

    });

});
