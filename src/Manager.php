<?php

namespace Laranav;

use Laranav\Menus\Menu;
use Illuminate\Contracts\Foundation\Application;

class Manager
{
    /**
     * The application instance.
     *
     * @var Application
     */
    protected $app;

    /**
     * The array of menus as defined in the config files.
     *
     * @var array
     */
    protected $menus;

    /**
     * Create a new `Manager` instance.
     *
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Get a `Menu` instance.
     *
     * @param  string $name
     *
     * @return Menu
     */
    public function menu($name = 'default')
    {
        return $this->menus[$name] = $this->get($name);
    }

    /**
     * Attempt to get the `Menu` instance from local cache, or resolve a new
     * instance.
     *
     * @param  string $name
     *
     * @return Menu
     */
    protected function get($name)
    {
        return isset($this->menus[$name]) ? $this->menus[$name] : $this->resolve($name);
    }

    /**
     * Resolve a new instance of `Menu`.
     *
     * @param  string $name
     *
     * @return Menu
     */
    protected function resolve($name)
    {
        $config = $this->getConfig($name);
        $items  = $this->getMenuItems($name);

        return new Menu(
            $name,
            $items,
            $config,
            $this->app['view'],
            $this->app['router']->getCurrentRequest()
        );
    }

    /**
     * Get a menu's configuration.
     *
     * @param  string  $name
     *
     * @return array
     */
    protected function getConfig($name)
    {
        return $this->app['config']["laranav.config.{$name}"];
    }

    /**
     * Get a menu's items.
     *
     * @param  string  $name
     *
     * @return array
     */
    protected function getMenuItems($name)
    {
        return $this->app['config']["laranav.menus.{$name}"];
    }

    /**
     * Dynamically call methods on the default `Menu` instance.
     *
     * @param  string  $method
     * @param  array   $parameters
     *
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return call_user_func_array([$this->menu(), $method], $parameters);
    }
}
