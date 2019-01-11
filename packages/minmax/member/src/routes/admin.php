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

    Route::group(['prefix' => 'siteadmin', 'namespace' => 'Minmax\Member\Admin', 'middleware' => 'auth:admin'], function () {
        /*
         |--------------------------------------------------------------------------
         | 需要登入的路由。
         |--------------------------------------------------------------------------
         */

        /*
         * Member 會員帳戶管理
         */
        Route::get('member', 'MemberController@index')->name('member.index');
        Route::post('member', 'MemberController@store')->name('member.store');
        Route::get('member/create', 'MemberController@create')->name('member.create');
        Route::get('member/{id}', 'MemberController@show')->name('member.show');
        Route::put('member/{id}', 'MemberController@update')->name('member.update');
        Route::put('member/detail/{id}', 'MemberDetailController@update')->name('member-detail.update');
        Route::get('member/auth/{token}', 'MemberAuthenticationController@authenticate')->name('member-authentication.authenticate');
        Route::post('member/auth/{id}', 'MemberAuthenticationController@store')->name('member-authentication.store');
        Route::delete('member/auth/{id}', 'MemberAuthenticationController@destroy')->name('member-authentication.destroy');
        Route::delete('member/{id}', 'MemberController@destroy')->name('member.destroy');
        Route::get('member/{id}/edit', 'MemberController@edit')->name('member.edit');
        Route::post('member/ajax/datatables', 'MemberController@ajaxDataTable')->name('member.ajaxDataTable');
        Route::patch('member/ajax/switch', 'MemberController@ajaxSwitch')->name('member.ajaxSwitch');

        /*
         * MemberTerm 會員條款
         */
        Route::get('member-term', 'MemberTermController@index')->name('member-term.index');
        Route::post('member-term', 'MemberTermController@store')->name('member-term.store');
        Route::get('member-term/create', 'MemberTermController@create')->name('member-term.create');
        Route::get('member-term/{id}', 'MemberTermController@show')->name('member-term.show');
        Route::put('member-term/{id}', 'MemberTermController@update')->name('member-term.update');
        Route::delete('member-term/{id}', 'MemberTermController@destroy')->name('member-term.destroy');
        Route::get('member-term/{id}/edit', 'MemberTermController@edit')->name('member-term.edit');
        Route::post('member-term/ajax/datatables', 'MemberTermController@ajaxDataTable')->name('member-term.ajaxDataTable');
        Route::patch('member-term/ajax/switch', 'MemberTermController@ajaxSwitch')->name('member-term.ajaxSwitch');
        Route::patch('member-term/ajax/sort', 'MemberTermController@ajaxSort')->name('member-term.ajaxSort');
        Route::patch('member-term/ajax/multi/switch', 'MemberTermController@ajaxMultiSwitch')->name('member-term.ajaxMultiSwitch');
        Route::delete('member-term/ajax/multi/delete', 'MemberTermController@ajaxMultiDestroy')->name('member-term.ajaxMultiDestroy');

    });

});
