<?php

namespace dvplex\Phantom;

use App\Http\Kernel;
use dvplex\Phantom\Classes\Phantom;
use dvplex\Phantom\Http\Middleware\PhantomMiddleware;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class PhantomServiceProvider extends ServiceProvider {
	/**
	 * Perform post-registration booting of services.
	 *
	 * @return void
	 */
	public function boot(Router $router, Kernel $kernel) {
		// override User model :-)
		config(['app.locales' => ['bg', 'en']]);
		config(['auth.providers.users.model' => Models\User::class]);

		$loader = AliasLoader::getInstance();
		$loader->alias('Phantom', Phantom::class);

		$router->aliasMiddleware('phantom', PhantomMiddleware::class);

		view()->composer('layouts.side-navbar', function () {
			phantom()->menu('main');
		});

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

		$this->app->singleton('phantom', function () {
			return $this->app->make('dvplex\Phantom\Classes\Phantom');
		});

		include __DIR__ . '/Http/routes.php';

		if ($this->app->runningInConsole()) {
			$this->commands([
				Commands\phantom::class,
			]);

		}
	}
}