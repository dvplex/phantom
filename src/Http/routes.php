<?php

Route::get('/{locale?}', 'dvplex\Phantom\Http\Controllers\PhantomController@redirect')->name('phantom.main');
Route::get('locale/{loc}', 'dvplex\Phantom\Http\Controllers\PhantomController@setLocale')->name('phantom.locale.path');
Route::get('timezones/{timezone?}',
	'dvplex\Phantom\Http\Controllers\PhantomController@index');
Route::group(['middleware' => ['web','phantom_locale'], 'namespace' => 'App\Http\Controllers'], function () {
	Route::get('{lang?}/login', 'Auth\LoginController@showLoginForm')->name('login');
	Route::post('login', 'Auth\LoginController@login');
	Route::post('logout', 'Auth\LoginController@logout')->name('logout');

	Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
	Route::post('register', 'Auth\RegisterController@register');

	Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
	Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
	Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
	Route::post('password/reset', 'Auth\ResetPasswordController@reset');
});

Route::group(['middleware' => ['web','phantom','phantom_locale'], 'namespace' => 'App\Http\Controllers'], function () {
	Route::get('/phantom/getOrderBy','dvplex\Phantom\Http\Controllers\PhantomController@getOrderBy');
});
