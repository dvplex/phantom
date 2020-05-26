<?php

Route::group(['middleware' => ['auth']], function () {
    Route::get('/{lang?}/admin/permissions/search', 'PermissionsController@search')->name('phantom.modules.permissions@search');
    Route::post('/{lang}/admin/permissions/add', 'PermissionsController@store')->name('phantom.modules.permissions@store');
    Route::post('/{lang}/admin/permissions/edit', 'PermissionsController@update')->name('phantom.modules.permissions@update');
    Route::post('/{lang}/admin/permissions/delete', 'PermissionsController@destroy')->name('phantom.modules.permissions@destroy');
});

