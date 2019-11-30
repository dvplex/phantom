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

        $this->loadViewsFrom(__DIR__ . '/Views', 'phantom');

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
        // local only helper test
        if (file_exists($file = __DIR__ . '/functions.php')) {
            require $file;
        }
        $this->app->singleton('phantom', function () {
            return $this->app->make('dvplex\Phantom\Classes\Phantom');
        });

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
