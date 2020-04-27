<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['auth']], function ($router) {
    Route::get('/{lang?}/admin/settings/modules/', 'ModulesController@index')->name('phantom.modules.modules@index');
    Route::get('/{lang?}/modules/search', 'ModulesController@search')->name('phantom.modules.modules@search');
    Route::get('/{lang?}/admin/settings/modules/{module}', 'ModulesController@show')->name('phantom.modules.modules@show');
    Route::post('/{lang}/admin/modules/add', 'ModulesController@store')->name('phantom.modules.modules@store');
    Route::post('/{lang}/admin/modules/edit', 'ModulesController@update')->name('phantom.modules.modules@update');
    Route::get('/{lang?}/admin/admin/settings', 'ModulesController@s_general')->name('phantom.modules.modules@settings');
    Route::get('/{lang?}/admin/settings/general', 'ModulesController@s_general')->name('phantom.modules.modules@s_general');
    Route::post('{lang}/admin/settings/save_prefs', 'ModulesController@save_prefs')->name('phantom.modules.modules@save_prefs');
});
Route::group(['middleware' => ['web']], function ($router) {
    Route::post('/api/alerts/getTrans', 'ModulesController@vue_trans')->name('phantom.modules.modules@vue_trans');
});
