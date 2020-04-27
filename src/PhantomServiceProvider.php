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

        $this->publishes([
            __DIR__ . '/config/phantom.php' => config_path('phantom.php'),
        ]);
        $cms_theme = config('phantom.cms_theme');
        $this->loadViewsFrom(__DIR__ . '/Views', 'phantom');
        if (is_dir(app_path('CMS')))
            $this->loadViewsFrom(app_path('/CMS/Themes/' . $cms_theme . '/views'), 'frontpage');

        $this->publishes([
            __DIR__ . '/Views/' => resource_path('views/vendor/phantom'),
        ]);

        PhantomValidator::boot();

    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register() {

        $this->loadRoutesFrom(__DIR__ . '/Http/routes.php');
        $this->loadMigrationsFrom(__DIR__ . '/Migrations/');

        if ($this->app->runningInConsole()) {
            $this->commands([
                Commands\phantom::class,
                Commands\PhantomForm::class,
                Commands\PhantomImapGet::class,
                Commands\phantomInitialSetup::class,
            ]);

        }
    }
}
