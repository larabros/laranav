<?php

namespace Laranav\Menus;

use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

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
     * @param string       $name
     * @param array        $items
     * @param array        $config
     * @param UrlGenerator $generator
     * @param Factory      $viewFactory
     */
    public function __construct(
        $name,
        array $items,
        array $config,
        UrlGenerator $generator,
        Factory $viewFactory
    ) {
        $this->name        = $name;
        $this->config      = $config;
        $this->request     = $generator->getRequest();
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

    /**
     * Returns `Collection` of `Item` objects.
     *
     * @return Collection
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Adds multiple items to the menu.
     *
     * @param array $items
     */
    public function addItems(array $items)
    {
        $this->items = $this->items->merge($this->createItems($items));
    }

    /**
     * Adds an item to the menu.
     *
     * @param string       $title
     * @param array|string $item
     */
    public function addItem($title, $item)
    {
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
            ->make($this->config['view'], ['menuItems' => $this->items->all()])
            ->render();
    }

    /**
     * Creates and returns a `Collection` of `Items`.
     *
     * @param  array $items
     *
     * @return Collection
     */
    protected function createItems(array $items)
    {
        $itemCollection = [];
        foreach ($items as $title => $item) {
            $itemCollection[] = $this->createItem($title, $item);
        }
        return new Collection($itemCollection);
    }

    /**
     * Creates and returns a new instance of `Item`.
     *
     * @param  string        $title
     * @param  array|string  $item
     *
     * @return Item
     */
    protected function createItem($title, $item)
    {
        // The best way to be ;)
        $children = null;
        $url      = $item;

        // If `$item` is an array, then attempt to generate a URL from the
        // provided parameters.
        if ($this->isItemArray($item) && !$this->hasNestedItems($item)) {
            $url = $this->generateItemUrl($item);
        }

        // If `$item` is an array and has a `default` key, then it has children.
        if ($this->hasNestedItems($item)) {
            // Get `default` item URL
            $url = $this->generateItemUrl($item['default']);

            // Create a `Collection` of the children items
            $children = $this->createItems(array_except($item, 'default'));
        }

        return new Item(
            $title,
            $url,
            $this->isUrlActive($url),
            $children,
            $this->config['active_class'],
            $this->config['children_class']
        );
    }

    /**
     * Checks whether an item is an array and contains one of the following keys:
     *
     * - `to`
     * - `secure`
     * - `asset`
     * - `route`
     * - `action`
     *
     * @param  array|string  $item
     *
     * @return boolean
     */
    protected function isItemArray($item)
    {
        return is_array($item)
            && in_array(key($item), ['to', 'secure', 'asset', 'route', 'action']);
    }

    /**
     * Checks whether an item has a `default` key.
     *
     * @param  array|string  $item
     *
     * @return boolean
     */
    protected function hasNestedItems($item)
    {
        return is_array($item) && in_array('default', array_keys($item));
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
        $path = trim(str_replace($this->request->root(), '', $url), '/');
        return $this->request->is($path);
    }

    /**
     * Generates a URL using `UrlGenerator`. If `$item` is a string, then it is
     * returned unchanged. If `$item` is an array, the key of the array
     * corresponds to a method on the `UrlGenerator` instance, and the value is
     * passed as a parameter.
     *
     * @param  array|string $item
     *
     * @return string
     */
    protected function generateItemUrl($item)
    {
        if ($this->isItemArray($item)) {
            $type = key($item);
            return $this->generator->$type($item[$type]);
        }
        return $item;
    }
}
