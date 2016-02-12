<?php

namespace Laranav\Menus;

use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Contracts\Routing\UrlGenerator;
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
     * The incoming `Request` object.
     *
     * @var Request
     */
    protected $request;

    /**
     * An instance of `UrlGenerator` used to generate any URLs for the menu items.
     *
     * @var UrlGenerator
     */
    protected $generator;

    /**
     * The `Factory` instance used to generate the views.
     *
     * @var Factory
     */
    protected $viewFactory;

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
        array $items = [],
        array $config,
        Request $request,
        UrlGenerator $generator,
        Factory $viewFactory
    ) {
        $this->name        = $name;
        $this->config      = $config;
        $this->request     = $request;
        $this->generator   = $generator;
        $this->viewFactory = $viewFactory;

        // Has to be done after other dependencies are set
        $this->items       = new Collection($this->createItems($items));
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

    public function addItems($items)
    {
        $this->items = $this->items->merge($this->createItems($items));
    }

    public function addItem($title, $item)
    {
        // Create a new `Item`
        $this->items->push($this->createItem($title, $item));
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

    protected function createItems($items)
    {
        $itemCollection = [];
        foreach ($items as $title => $item) {
            $itemCollection[] = $this->createItem($title, $item);
        }
        return new Collection($itemCollection);
    }

    /**
     * Creates `Item` objects from an (nested) array of `$items` and returns
     * a `Collection`.
     *
     * @param  array $item
     *
     * @return Item
     */
    protected function createItem($title, $item)
    {
        // The best way to be ;)
        $children   = null;
        $default    = $item;

        // If `$item` is an array and that array has a `route` key, then
        // attempt to generate a URL from the route name.
        if ($this->isRouteItem($item)) {
            $default = $this->getRouteItemUrl($item);
        }

        // If `$item` is an array and that array has a `default` key, then
        // the item has children.
        if ($this->isNestedItem($item)) {

            // Get `default` item URL
            $default = array_only($item, 'default')['default'];

            if ($this->isRouteItem($default)) {
                $default = $this->getRouteItemUrl($default);
            }

            // Create a `Collection` of the children items
            $children = $this->createItems(array_except($item, 'default'));
        }

        return new Item(
            $title,
            $default,
            $this->isUrlActive($default),
            $children,
            $this->config['active_class'],
            $this->config['children_class']
        );
    }

    protected function isRouteItem($item)
    {
        return is_array($item) && array_has($item, 'route');
    }

    protected function isNestedItem($item)
    {
        return is_array($item) && array_has($item, 'default');
    }

    protected function getRouteItemUrl(array $item)
    {
        return $this->generator->route($item['route']);
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
        if(is_array($url)) {
            // dd($url);
        }
        // var_dump($url);
        return $this->request->is($url);
    }
}
