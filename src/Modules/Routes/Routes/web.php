<?php

Route::group(['middleware' => ['auth']], function () {
    Route::get('/{lang}/admin/routes/search/{moduleId?}', 'RoutesController@search')->name('phantom.modules.routes@search');
    Route::post('/{lang?}/admin/routes/add/', 'RoutesController@store')->name('phantom.modules.routes@store');
    Route::post('/{lang?}/admin/routes/edit/', 'RoutesController@update')->name('phantom.modules.routes@update');
    Route::post('/{lang?}/admin/routes/delete/', 'RoutesController@destroy')->name('phantom.modules.routes@destroy');
});

