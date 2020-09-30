<?php

namespace Wjj1021\Polyv;

use Illuminate\Support\ServiceProvider;

class PolyvServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'wjj1021');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'wjj1021');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/polyv.php', 'polyv');

        // Register the service the package provides.
        $this->app->singleton('polyv', function ($app) {
            return new Polyv;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['polyv'];
    }
    
    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/polyv.php' => config_path('polyv.php'),
        ], 'polyv.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/wjj1021'),
        ], 'polyv.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/wjj1021'),
        ], 'polyv.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/wjj1021'),
        ], 'polyv.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
