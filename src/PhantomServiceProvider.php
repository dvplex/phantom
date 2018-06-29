<?php

namespace dvplex\Phantom;

use App\Http\Kernel;
use dvplex\Phantom\Classes\Phantom;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class PhantomServiceProvider extends ServiceProvider {
	/**
	 * Perform post-registration booting of services.
	 *
	 * @return void
	 */
	public function boot(Router $router, Kernel $kernel) {

		Phantom::registerRoutes();

		Phantom::registerConfig();

		Phantom::registerAliases();

		Phantom::eventsListen();

		$this->loadViewsFrom(__DIR__ . '/resources/views', 'phantom');

		$this->publishes([
			__DIR__ . '/resources/views' => base_path('resources/views/dvplex/phantom'),
		]);

		Validator::extend('without_spaces', function ($attr, $value) {
			return preg_match('/^\S*$/u', $value);
		});

	}

	/**
	 * Register any package services.
	 *
	 * @return void
	 */
	public function register() {
		// local only fasade test

		if (file_exists($file = __DIR__ . '/functions.php')) {
			require $file;
		}

		$this->app->singleton('phantom', function () {
			return $this->app->make('dvplex\Phantom\Classes\Phantom');
		});

		$this->loadRoutesFrom(__DIR__ . '/Http/routes.php');

		if ($this->app->runningInConsole()) {
			$this->commands([
				Commands\phantom::class,
				Commands\phantomUpdate::class,
			]);

		}
	}
}