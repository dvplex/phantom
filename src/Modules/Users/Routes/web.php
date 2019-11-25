<?php

Route::group(['middleware' => ['auth']], function () {
	Route::get('/{lang?}/admin/settings/users/', 'UsersController@index')->name('phantom.modules.users@index');
	Route::get('/{lang?}/users/search', 'UsersController@search')->name('phantom.modules.users@search');
	Route::get('/{lang?}/admin/settings/users/{user}', 'UsersController@show')->name('phantom.modules.users@show');
	Route::post('/{lang}/users/add', 'UsersController@store')->name('phantom.modules.users@store');
	Route::post('/{lang}/users/edit', 'UsersController@update')->name('phantom.modules.users@update');
	Route::get('/rpc/users/add/{view}', 'usersController@create')->name('phantom.modules.users@create');

});

