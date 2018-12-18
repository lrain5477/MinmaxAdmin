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
    'namespace' => 'Minmax\World\Admin',
    'as' => 'admin.' . app()->getLocale() . '.'
], function() {

    Route::group(['prefix' => 'siteadmin', 'middleware' => 'auth:admin'], function () {
        /*
         |--------------------------------------------------------------------------
         | 需要登入的路由。
         |--------------------------------------------------------------------------
         */

        /*
         * WorldContinent 大洲管理
         */
        Route::get('world-continent', 'WorldContinentController@index')->name('world-continent.index');
        Route::post('world-continent', 'WorldContinentController@store')->name('world-continent.store');
        Route::get('world-continent/create', 'WorldContinentController@create')->name('world-continent.create');
        Route::get('world-continent/{id}', 'WorldContinentController@show')->name('world-continent.show');
        Route::put('world-continent/{id}', 'WorldContinentController@update')->name('world-continent.update');
        Route::delete('world-continent/{id}', 'WorldContinentController@destroy')->name('world-continent.destroy');
        Route::get('world-continent/{id}/edit', 'WorldContinentController@edit')->name('world-continent.edit');
        Route::post('world-continent/ajax/datatables', 'WorldContinentController@ajaxDataTable')->name('world-continent.ajaxDataTable');
        Route::patch('world-continent/ajax/switch', 'WorldContinentController@ajaxSwitch')->name('world-continent.ajaxSwitch');
        Route::patch('world-continent/ajax/sort', 'WorldContinentController@ajaxSort')->name('world-continent.ajaxSort');

        /*
         * WorldCountry 國家管理
         */
        Route::get('world-country', 'WorldCountryController@index')->name('world-country.index');
        Route::post('world-country', 'WorldCountryController@store')->name('world-country.store');
        Route::get('world-country/create', 'WorldCountryController@create')->name('world-country.create');
        Route::get('world-country/{id}', 'WorldCountryController@show')->name('world-country.show');
        Route::put('world-country/{id}', 'WorldCountryController@update')->name('world-country.update');
        Route::delete('world-country/{id}', 'WorldCountryController@destroy')->name('world-country.destroy');
        Route::get('world-country/{id}/edit', 'WorldCountryController@edit')->name('world-country.edit');
        Route::post('world-country/ajax/datatables', 'WorldCountryController@ajaxDataTable')->name('world-country.ajaxDataTable');
        Route::patch('world-country/ajax/switch', 'WorldCountryController@ajaxSwitch')->name('world-country.ajaxSwitch');
        Route::patch('world-country/ajax/sort', 'WorldCountryController@ajaxSort')->name('world-country.ajaxSort');

        /*
         * WorldState 州區管理
         */
        Route::get('world-state', 'WorldStateController@index')->name('world-state.index');
        Route::post('world-state', 'WorldStateController@store')->name('world-state.store');
        Route::get('world-state/create', 'WorldStateController@create')->name('world-state.create');
        Route::get('world-state/{id}', 'WorldStateController@show')->name('world-state.show');
        Route::put('world-state/{id}', 'WorldStateController@update')->name('world-state.update');
        Route::delete('world-state/{id}', 'WorldStateController@destroy')->name('world-state.destroy');
        Route::get('world-state/{id}/edit', 'WorldStateController@edit')->name('world-state.edit');
        Route::post('world-state/ajax/datatables', 'WorldStateController@ajaxDataTable')->name('world-state.ajaxDataTable');
        Route::patch('world-state/ajax/switch', 'WorldStateController@ajaxSwitch')->name('world-state.ajaxSwitch');
        Route::patch('world-state/ajax/sort', 'WorldStateController@ajaxSort')->name('world-state.ajaxSort');

        /*
         * WorldCounty 縣市管理
         */
        Route::get('world-county', 'WorldCountyController@index')->name('world-county.index');
        Route::post('world-county', 'WorldCountyController@store')->name('world-county.store');
        Route::get('world-county/create', 'WorldCountyController@create')->name('world-county.create');
        Route::get('world-county/{id}', 'WorldCountyController@show')->name('world-county.show');
        Route::put('world-county/{id}', 'WorldCountyController@update')->name('world-county.update');
        Route::delete('world-county/{id}', 'WorldCountyController@destroy')->name('world-county.destroy');
        Route::get('world-county/{id}/edit', 'WorldCountyController@edit')->name('world-county.edit');
        Route::post('world-county/ajax/datatables', 'WorldCountyController@ajaxDataTable')->name('world-county.ajaxDataTable');
        Route::patch('world-county/ajax/switch', 'WorldCountyController@ajaxSwitch')->name('world-county.ajaxSwitch');
        Route::patch('world-county/ajax/sort', 'WorldCountyController@ajaxSort')->name('world-county.ajaxSort');

        /*
         * WorldCity 城鎮管理
         */
        Route::get('world-city', 'WorldCityController@index')->name('world-city.index');
        Route::post('world-city', 'WorldCityController@store')->name('world-city.store');
        Route::get('world-city/create', 'WorldCityController@create')->name('world-city.create');
        Route::get('world-city/{id}', 'WorldCityController@show')->name('world-city.show');
        Route::put('world-city/{id}', 'WorldCityController@update')->name('world-city.update');
        Route::delete('world-city/{id}', 'WorldCityController@destroy')->name('world-city.destroy');
        Route::get('world-city/{id}/edit', 'WorldCityController@edit')->name('world-city.edit');
        Route::post('world-city/ajax/datatables', 'WorldCityController@ajaxDataTable')->name('world-city.ajaxDataTable');
        Route::patch('world-city/ajax/switch', 'WorldCityController@ajaxSwitch')->name('world-city.ajaxSwitch');
        Route::patch('world-city/ajax/sort', 'WorldCityController@ajaxSort')->name('world-city.ajaxSort');

    });

});
