<?php

namespace dvplex\Phantom;

use Illuminate\Support\ServiceProvider;

class PhantomServiceProvider extends ServiceProvider {
	/**
	 * Perform post-registration booting of services.
	 *
	 * @return void
	 */
	public function boot() {
		//
		$this->loadViewsFrom(__DIR__ . '/resources/views', 'phantom');
		$this->publishes([
			__DIR__ . '/resources/views' => base_path('resources/views/dvplex/phantom'),
		]);
	}

	/**
	 * Register any package services.
	 *
	 * @return void
	 */
	public function register() {
		include __DIR__ . '/Http/routes.php';
		$this->app->make('dvplex\Phantom\Http\Controllers\PhantomController');
		if ($this->app->runningInConsole()) {
			$this->commands([
				Commands\phantom::class,
			]);

		}
	}
}