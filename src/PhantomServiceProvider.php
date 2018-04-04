<?php

namespace dvplex\Phantom;

use Illuminate\Support\ServiceProvider;
use Spatie\Menu\Laravel\Html;
use Spatie\Menu\Laravel\Link;
use Spatie\Menu\Laravel\Menu;
use Illuminate\Support\Facades\Lang;

class PhantomServiceProvider extends ServiceProvider {
	/**
	 * Perform post-registration booting of services.
	 *
	 * @return void
	 */
	public function boot() {
		//

		\Config::set(['phantom' => ['mainModule' => 'admin']]);
		view()->composer('layouts.side-navbar', function () {
			Menu::macro('main', function () {
				$menu = Menu::new();
				$menu->addClass('site-menu');
				$menu->addItemClass('site-menu-item');
				$menu->setAttribute('data-plugin', 'menu');
				$menu->html('<li class="site-menu-category">' . Lang::get('menu.menu') . '</li>');
				$menu->html('
							<a href="/' . app()->getLocale() . '/admin">
							<i class="site-menu-icon wb-dashboard" aria-hidden="true"></i>
							<span class="site-menu-title">' . Lang::get('menu.Dashboard') . '</span>
							<div class="site-menu-badge">
								<span class="badge badge-pill badge-success">3</span>
							</div>
						</a>
				')->addItemParentClass('site-menu-item');

				return $menu;
			});
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

		$this->app->bind('dvplex\Phantom\Classes\Dog');
		$this->app->singleton('dog', function () {
			return $this->app->make('dvplex\Phantom\Classes\Dog');
		});
		include __DIR__ . '/Http/routes.php';
		$this->app->make('dvplex\Phantom\Http\Controllers\PhantomController');
		if ($this->app->runningInConsole()) {
			$this->commands([
				Commands\phantom::class,
			]);

		}
	}
}