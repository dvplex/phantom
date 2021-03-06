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
    Route::get('/{lang?}/admin/settings/menus/', 'MenusController@index')->name('phantom.modules.menus@index');
    Route::get('/{lang?}/menus/search', 'MenusController@search')->name('phantom.modules.menus@search');
    Route::get('/{lang?}/admin/settings/menus/{menu:name}', 'MenusController@show')->name('phantom.modules.menus@show');
    Route::post('/{lang}/admin/menus/add', 'MenusController@store')->name('phantom.modules.menus@store');
    Route::post('/{lang}/admin/menus/edit', 'MenusController@update')->name('phantom.modules.menus@update');
    Route::post('/{lang}/admin/menus/delete', 'MenusController@destroy')->name('phantom.modules.menus@delete');
});

Route::group(['middleware' => ['web']], function ($router) {
    Route::post('/api/menu/buildTree', 'MenusController@buildTree')->name('phantom.modules.menus@build_tree');
});
