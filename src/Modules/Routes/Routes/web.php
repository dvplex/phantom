<?php

Route::group(['middleware' => ['auth']], function () {
    Route::get('/{lang}/routes/search/{moduleId?}', 'RoutesController@search')->name('phantom.modules.routes@search');
    Route::post('/{lang?}/routes/add/', 'RoutesController@store')->name('phantom.modules.routes@store');
    Route::post('/{lang?}/routes/edit/', 'RoutesController@update')->name('phantom.modules.routes@update');
    Route::post('/{lang?}/routes/delete/', 'RoutesController@destroy')->name('phantom.modules.routes@destroy');
});

