<?php

namespace dvplex\Phantom;

use dvplex\Phantom\Facades\Phantom;
use dvplex\Phantom\Classes\PhantomValidator;
use Illuminate\Support\ServiceProvider;

class PhantomServiceProvider extends ServiceProvider {
	/**
	 * Perform post-registration booting of services.
	 *
	 * @return void
	 */
	public function boot() {

		Phantom::registerAliases();

		Phantom::registerRoutes();

		Phantom::registerConfig();

		Phantom::eventsListen();

		$this->loadViewsFrom(__DIR__ . '/resources/views', 'phantom');

		$this->publishes([
			__DIR__ . '/resources/views' => base_path('resources/views/dvplex/phantom'),
		]);

		PhantomValidator::boot();

	}

	/**
	 * Register any package services.
	 *
	 * @return void
	 */
	public function register() {
		// local only helper test
		$this->app->singleton('phantom', function () {
			return $this->app->make('dvplex\Phantom\Classes\Phantom');
		});

		$this->loadRoutesFrom(__DIR__ . '/Http/routes.php');

		if ($this->app->runningInConsole()) {
			$this->commands([
				Commands\phantom::class,
				Commands\phantomUpdate::class,
				Commands\PhantomForm::class,
				Commands\PhantomImapGet::class,
				Commands\phantomInitialSetup::class,
			]);

		}
	}
}