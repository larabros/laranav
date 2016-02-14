<?php

namespace Laranav\Menus;

use Illuminate\Contracts\View\View;

abstract class Composer
{
    /**
     * The `Menu` instance used by this view composer.
     *
     * @var Menu
     */
    protected $menu;

    /**
     * Create a new `Composer` instance.
     *
     * @param Menu $menu
     */
    public function __construct(Menu $menu)
    {
        $this->menu = $menu;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     */
    public function compose(View $view)
    {
        $view->with('menuItems', $this->menu->getItems());
    }
}
