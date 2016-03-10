<?php

namespace Larabros\Laranav;

use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class LaranavServiceProvider extends ServiceProvider
{
    /**
     * @inheritDoc
     */
    public function boot()
    {
        // Config files
        $this->publishes([
            __DIR__.'/config/config.php' => config_path('laranav/config.php'),
            __DIR__.'/config/menus.php'  => config_path('laranav/menus.php'),
        ], 'config');

        // Views
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'laranav');
        $this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/laranav'),
        ], 'views');
    }

    /**
     * @inheritDoc
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/config/config.php', 'laranav.config');
        $this->mergeConfigFrom(__DIR__.'/config/menus.php', 'laranav.menus');

        $this->app->singleton('nav', function ($app) {
            return new Manager($app);
        });
    }

    /**
     * @inheritDoc
     */
    public function provides()
    {
        return ['nav'];
    }
}
