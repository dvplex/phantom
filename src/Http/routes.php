<?php

Route::get('/', function () {
	return redirect('admin');
});
Route::get('locale', function () {
	return \App::getLocale();
});
Route::get('locale/{loc}/{path}', function ($loc, $path) {
	return phantom_route($loc);
});
Route::get('timezones/{timezone?}',
	'dvplex\Phantom\Http\Controllers\PhantomController@index');

Route::group(['middleware' => 'web', 'namespace' => 'App\Http\Controllers'], function () {
	Auth::routes();
});

