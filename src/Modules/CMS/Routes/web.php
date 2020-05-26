<?php

Route::group(['middleware' => ['auth']], function () {
	Route::get('/{lang?}/admin/cms', 'CMSController@index')->name('phantom.modules.cms@index');
	Route::get('/{lang?}/admin/cms/search/', 'CMSController@search')->name('phantom.modules.cms@search');
	Route::get('/{lang?}/admin/cms/add/', 'CMSController@create')->name('phantom.modules.cms@create');
	Route::get('/{lang?}/admin/cms/{id}/', 'CMSController@show')->name('phantom.modules.cms@show');
	Route::get('/{lang?}/admin/cms/modify/{id}/', 'CMSController@edit')->name('phantom.modules.cms@edit');
	Route::post('/{lang?}/admin/cms/add/', 'CMSController@store')->name('phantom.modules.cms@store');
	Route::post('/{lang?}/admin/cms/edit/', 'CMSController@update')->name('phantom.modules.cms@update');
	Route::post('/{lang?}/admin/cms/delete/', 'CMSController@destroy')->name('phantom.modules.cms@destroy');

});

