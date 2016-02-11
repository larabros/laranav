<?php

namespace Laranav;

use Illuminate\Support\ServiceProvider;

class LaranavServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(Request $request)
    {
        // Config files
        $this->publishes([
            __DIR__.'/config/config.php' => config_path('laranav/config.php'),
            __DIR__.'/config/menus.php'  => config_path('laranav/menus.php'),
        ], 'config');

        // Views
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'laranav');
        // $this->publishes([
        //     __DIR__.'/../resources/views' => base_path('resources/views/vendor/laranav'),
        // ], 'views');
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/config/config.php', 'laranav.config');
        $this->mergeConfigFrom(__DIR__.'/config/menus.php', 'laranav.menus');

        $this->app->singleton('nav', function ($app) {
            return new Manager($app);
        });
    }
}
