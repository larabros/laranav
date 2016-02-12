<?php

namespace Laranav\Menus;

use Illuminate\Support\Collection;
use Illuminate\Http\Request;
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
     * Any configuration options for the menu.
     *
     * @var array
     */
    protected $config;

    /**
     * The `Factory` instance used to generate the views.
     *
     * @var Factory
     */
    protected $viewFactory;

    /**
     * The incoming `Request` object.
     *
     * @var Request
     */
    protected $request;

    /**
     * Create a new `Menu` instance.
     *
     * @param string  $name
     * @param array   $items
     * @param array   $config
     * @param Factory $viewFactory
     * @param Request $request
     */
    public function __construct(
        $name = 'default',
        array $items,
        array $config,
        Factory $viewFactory,
        Request $request
    ) {
        $this->name        = $name;
        $this->config      = $config;
        $this->viewFactory = $viewFactory;
        $this->request     = $request;

        $this->items       = $this->createItems($items);
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
            ->make($this->config['views']['menu'], ['menuItems' => $this->items->all()])
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
            $default = $url;

            // If `$url` is an array, then the item has children - create a
            // sub-collection of `Items`.
            if (is_array($url)) {

                // Get `default` item URL
                $default = array_only($url, 'default')['default'];

                // Create a `Collection` of the children items
                $children = $this->createItems(array_except($url, 'default'));
            }

            // Create a new `Item`
            $itemCollection[] = new Item(
                $title,
                $default,
                $this->isUrlActive($default),
                $this->config['active_class'],
                $children,
                $this->config['children_class']
            );
        }

        return new Collection($itemCollection);
    }

    /**
     * Checks if a provided URL is active or not.
     *
     * @param  string  $url
     *
     * @return boolean
     */
    protected function isUrlActive($url)
    {
        return $this->request->is($url);
    }
}
