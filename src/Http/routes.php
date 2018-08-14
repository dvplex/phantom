<?php

Route::group(['middleware' => ['web','phantom_locale'],'namespace'=>'App\Http\Controllers'], function () {
	Route::get('/{lang?}', 'HomeController@index')->name('frontpage.main');
});
Route::get('locale/{loc}', 'dvplex\Phantom\Http\Controllers\PhantomController@setLocale')->name('phantom.locale.path');
Route::get('timezones/{timezone?}',
	'dvplex\Phantom\Http\Controllers\PhantomController@index')->name('timezone');
Route::group(['middleware' => ['web','phantom_locale'], 'namespace' => 'App\Http\Controllers'], function () {
	Route::get('{lang?}/login', 'Auth\LoginController@showLoginForm')->name('login');
	Route::post('login', 'Auth\LoginController@login')->name('login');
	Route::post('logout', 'Auth\LoginController@logout')->name('logout');

	Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('showRegisterForm');
	Route::post('register', 'Auth\RegisterController@register')->name('register');

	Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
	Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
	Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
	Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.reset');
});

