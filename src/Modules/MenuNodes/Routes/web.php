<?php

Route::group(['middleware' => ['auth']], function () {
    Route::get('/{lang?}/admin/settings/menuNodes/', 'MenuNodesController@index')->name('phantom.modules.menuNodes@index');
    Route::get('/{lang?}/menuNodes/search', 'MenuNodesController@search')->name('phantom.modules.menuNodes@search');
    Route::get('/{lang?}/admin/settings/menuNodes/{module}', 'MenuNodesController@show')->name('phantom.modules.menuNodes@show');
    Route::post('/{lang}/admin/menuNodes/add', 'MenuNodesController@store')->name('phantom.modules.menuNodes@store');
    Route::post('/{lang}/admin/menuNodes/edit', 'MenuNodesController@update')->name('phantom.modules.menuNodes@update');
    Route::post('/{lang?}/admin/menuNodes/delete/', 'MenuNodesController@destroy')->name('phantom.modules.menuNodes@destroy');

});

