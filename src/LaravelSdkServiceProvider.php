<?php

namespace Wasiliana\LaravelSdk;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

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
        $this->mergeConfigFrom(__DIR__.'/../config/laravel-sdk.php', 'laravel-sdk');

        // Register the service the package provides.
        $this->app->singleton(LaravelSdk::class, function ($app) {
            $config = config('laravel-sdk.api');
            return new LaravelSdk(new Client([
                'base_uri' => 'https://api.wasiliana.com/api/v1/developer/',
                'headers' => [
                    'apiKey' => $config['key'],
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ]
            ]));
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
            __DIR__.'/../config/laravel-sdk.php' => config_path('laravel-sdk.php'),
        ], 'laravel-sdk.config');

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
        // $this->commands([]);
    }
}
