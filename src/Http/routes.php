<?php

Route::group(['middleware' => ['web'], 'namespace' => 'dvplex\Phantom\Http\Controllers'], function () {
    Route::get('locale/{loc}', 'PhantomController@setLocale')->name('phantom.locale.path');
    Route::post('lock', 'PhantomController@lock')->name('system-lock');
});
Route::get('{lang}/timezones/{timezone?}',
	'dvplex\Phantom\Http\Controllers\PhantomController@index')->name('timezone');
Route::group(['middleware' => ['web'], 'namespace' => 'App\Http\Controllers'], function () {
	Route::get('{lang?}/login', 'Auth\LoginController@showLoginForm')->name('login');
	Route::post('login', 'Auth\LoginController@login')->name('login');
	Route::post('logout', 'Auth\LoginController@logout')->name('logout');
});

