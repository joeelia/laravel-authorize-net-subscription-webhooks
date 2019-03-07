<?php

namespace Joeelia\AuthorizeNet;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Joeelia\AuthorizeNet\Commands\WebhookJobMakeCommand;
use Joeelia\AuthorizeNet\Webhooks\AuthorizeNetWebhooksController;

class AuthorizeNetServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'authorize-net');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'authorize-net');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->registerRoutes();

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/authorize-net-webhooks.php' => config_path('authorize-net-webhooks.php'),
            ], 'config');
            $this->commands([
                WebhookJobMakeCommand::class,
            ]);
            // Registering package commands.
            // $this->commands([]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/authorize-net-webhooks.php', 'authorize-net');

        // Register the main class to use with the facade
        $this->app->singleton('authorize-net', function () {
            return new AuthorizeNet;
        });
    }

    protected function registerRoutes()
    {
        Route::post(config('authorize-net-webhooks.webhookPostRoute'), AuthorizeNetWebhooksController::class);
    }
}
