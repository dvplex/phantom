<?php

Route::group(['middleware' => ['auth']], function () {
    Route::get('/{lang?}/permissions/search', 'PermissionsController@search')->name('phantom.modules.permissions@search');
    Route::post('/{lang}/permissions/add', 'PermissionsController@store')->name('phantom.modules.permissions@store');
    Route::post('/{lang}/permissions/edit', 'PermissionsController@update')->name('phantom.modules.permissions@update');
    Route::get('/rpc/permissions/add/{view}', 'PermissionsController@create')->name('phantom.modules.permissions@create');
});

