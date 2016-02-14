<?php

namespace Laranav;

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

        $this->registerViewComposers();
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

    /**
     * Binds any view composers found in the config to the container.
     *
     * @return void
     */
    protected function registerViewComposers()
    {
        $configs = $this->app['config']['laranav.config'];

        foreach ($configs as $title => $config) {
            if (array_key_exists('view_composer', $config)) {

                // Bind view composer to container
                $this->app->bind($config['view_composer'], function($app) use ($title, $config) {
                    $menu         = $app->make('nav')->menu($title);
                    $viewComposer = $config['view_composer'];
                    return new $viewComposer($menu);
                });

                // Bind view composer to view
                $this->app->make('view')->composer($config['views']['menu'], $config['view_composer']);
            }
        }
    }
}
