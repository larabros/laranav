<?php

namespace Laranav\Menus;

use Illuminate\Support\Collection;
use Illuminate\Contracts\View\Factory;

class Menu
{
    /**
     * The unique name used to identify a `Menu` instance.
     *
     * @var string
     */
    protected $name;

    /**
     * The menu's items.
     *
     * @var Collection
     */
    protected $items;

    /**
     * The `Factory` instance used to generate the views.
     *
     * @var Factory
     */
    protected $viewFactory;

    /**
     * Any configuration options for the menu.
     *
     * @var array
     */
    protected $config;

    /**
     * Create a new `Menu` instance.
     *
     * @param string  $name
     * @param array   $items
     * @param array   $config
     * @param Factory $viewFactory
     */
    public function __construct(
        $name = 'default',
        array $items,
        array $config,
        Factory $viewFactory
    ) {
        $this->name        = $name;
        $this->items       = $this->createItems($items);
        $this->config      = $config;
        $this->viewFactory = $viewFactory;
    }

    /**
     * Return name of `Menu` instance.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Renders the menu as a HTML string and returns it.
     *
     * @return string
     */
    public function toHtml()
    {
        return $this->viewFactory
            ->make($this->config['views']['menu'], $this->items->roots())
            ->render();
    }

    /**
     * Creates `Item` objects from an (nested) array of `$items` and returns
     * a `Collection`.
     *
     * @param  array $items
     *
     * @return Collection
     */
    protected function createItems($items)
    {
        $itemCollection = [];
        foreach ($items as $title => $url) {

            // The best way to be ;)
            $children = null;
            $childItems = [];

            // If `$url` is an array, then the item has children - create a
            // sub-collection of `Items`.
            if (is_array($url)) {

                // Shift the default value from first position
                $default = array_shift($url);

                // Create a `Collection` of the children items
                $children = $this->createItems($url);
            }

            // Create a new `Item`
            $itemCollection[] = new Item($title, $url, false, $children);
        }

        return new Collection($itemCollection);
    }

    protected function isUrlActive($url)
    {
        return $this->request->is($url);
    }
}
