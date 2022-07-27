<?php

namespace Wasiliana\LaravelSdk;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;
use Wasiliana\LaravelSdk\Console\InstallPackage;
use Wasiliana\LaravelSdk\Service\Sms;

class LaravelSdkServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'wasiliana');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'wasiliana');
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
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/wasiliana.php', 'wasiliana');

        $this->app->bind('ws_sms', function ($app) {
            return new Sms();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['laravel-sdk'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__ . '/../config/wasiliana.php' => config_path('wasiliana.php'),
        ], 'config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/wasiliana'),
        ], 'laravel-sdk.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/wasiliana'),
        ], 'laravel-sdk.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/wasiliana'),
        ], 'laravel-sdk.views');*/

        // Registering package commands.
        $this->commands([
            InstallPackage::class,
        ]);
    }
}
