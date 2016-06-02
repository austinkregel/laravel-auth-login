<?php

namespace Kregel\AuthLogin;

use Illuminate\Support\ServiceProvider;

class AuthLoginServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        $this->app->booted(function () {
            $this->defineRoutes();
        });

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'auth-login');
        $this->publishes([
            __DIR__ . '/../resources/views' => base_path('resources/views/vendor/auth-login'),
        ], 'views');
        $this->publishes([
            __DIR__ . '/../config/config.php' => config_path('kregel/auth-login.php'),
        ], 'config');
    }

    /**
     * Define the UserManagement routes.
     */
    protected function defineRoutes()
    {
        if (!$this->app->routesAreCached()) {
            $router = app('router');

            $router->group(['namespace' => 'Kregel\\AuthLogin\\Http\\Controllers'], function ($router) {
                require __DIR__ . '/Http/routes.php';
            });
        }
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->register(\Tymon\JWTAuth\Providers\LaravelServiceProvider::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
