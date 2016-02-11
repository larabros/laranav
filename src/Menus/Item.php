<?php

namespace Laranav\Menus;

use Illuminate\Support\Collection;

class Item
{
    /**
     * The unique name used to identify an `Item` instance.
     *
     * @var string
     */
    protected $title;

    /**
     * The URL for the item.
     *
     * @var string
     */
    protected $url;

    /**
     * A `Collection` of `Item` instances for any child items.
     *
     * @var Collection|null
     */
    protected $children;

    /**
     * Create a new `Item` instance.
     *
     * @param string          $title
     * @param string          $url
     * @param boolean         $isActive
     * @param Collection|null $children
     */
    public function __construct($title, $url = '#', $isActive = false, Collection $children = null)
    {
        $this->title    = $title;
        $this->url      = $url;
        $this->children = $children;
    }

    /**
     * Return title of the `Item` instance.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Return the URL of the `Item` instance.
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Check if this item has any children.
     *
     * @return boolean
     */
    public function hasChildren()
    {
        return (isset($this->children) && !is_null($this->children));
    }

    /**
     * Returns any child items as a `Collection`.
     *
     * @return Collection
     */
    public function getChildren()
    {
        return $this->hasChildren() ? $this->children : new Collection();
    }

    /**
     * Returns any CSS classes that should be applied to this class, for
     * example active links and nested menu items generally have different
     * styling.
     *
     * @return string
     */
    public function getClasses()
    {
        // Check if this is the active item
        if ($this->isActive()) {
            # code...
        }
    }
}
