<?php

Route::group(['middleware' => ['auth']], function () {
    Route::get('/{lang?}/admin/settings/roles/', 'RolesController@index')->name('phantom.modules.roles@index');
    Route::get('/{lang?}/admin/roles/search', 'RolesController@search')->name('phantom.modules.roles@search');
    Route::get('/{lang?}/admin/settings/roles/{module}', 'RolesController@show')->name('phantom.modules.roles@show');
    Route::post('/{lang}/admin/roles/add', 'RolesController@store')->name('phantom.modules.roles@store');
    Route::post('/{lang}/admin/roles/edit', 'RolesController@update')->name('phantom.modules.roles@update');
});

