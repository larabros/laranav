<?php

namespace Laranav;

use Laranav\Menus\Menu;
use Illuminate\Support\Manager as AbstractManager;
use Illuminate\Contracts\Foundation\Application;

class Manager extends AbstractManager
{
    /**
     * The array of menus as defined in the config files.
     *
     * @var array
     */
    protected $menus;

    /**
     * Get a `Menu` instance.
     *
     * @param  string $name
     *
     * @return Menu
     */
    public function menu($name = null)
    {
        $name = $name ?: $this->getDefaultDriver();
        return $this->menus[$name] = $this->driver($name);
    }

    /**
     * @inheritDoc
     */
    public function getDefaultDriver()
    {
        return 'default';
    }

    /**
     * @inheritDoc
     */
    public function driver($name = null)
    {
        return isset($this->menus[$name]) ? $this->menus[$name] : $this->createDriver($name);
    }

    /**
     * @inheritDoc
     */
    protected function createDriver($name)
    {
        $config = $this->getConfig($name);
        $items  = $this->getMenuItems($name);

        return new Menu(
            $name,
            $items,
            $config,
            $this->app->make('url'),
            $this->app->make('view')
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
        return $this->app->make('config')->get("laranav.config.{$name}");
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
        return $this->app->make('config')->get("laranav.menus.{$name}");
    }
}
