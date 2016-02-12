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
     * The active state of the item.
     *
     * @var bool
     */
    protected $isActive;

    /**
     * The CSS class used to highlight an active item.
     *
     * @var string
     */
    protected $activeClass;

    /**
     * A `Collection` of `Item` instances for any child items.
     *
     * @var Collection|null
     */
    protected $children;

    /**
     * The CSS class used to highlight an item with children.
     *
     * @var string
     */
    protected $childrenClass;

    /**
     * Create a new `Item` instance.
     *
     * @param string          $title
     * @param string          $url
     * @param boolean         $isActive
     * @param Collection|null $children
     */
    public function __construct(
        $title,
        $url = '#',
        $isActive = false,
        Collection $children = null,
        $activeClass = 'active',
        $childrenClass = 'dropdown'
    ) {
        $this->title         = $title;
        $this->url           = $url;
        $this->isActive      = $isActive;
        $this->children      = $children;
        $this->activeClass   = $activeClass;
        $this->childrenClass = $childrenClass;
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
     * Returns the active status of the item.
     *
     * @return boolean
     */
    public function isActive()
    {
        return $this->isActive;
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
     * Returns any CSS classes that should be applied to this item when, for
     * example highlighting an active link, or displaying a menu item with children.
     *
     * @return string
     */
    public function getClasses()
    {
        $classesString = '';

        // Check if this is the active item
        if ($this->isActive()) {
            $classesString += $this->activeClass + ' ';
        }

        if ($this->hasChildren()) {
            $classesString += $this->childrenClass + ' ';
        }

        return trim($classesString);
    }
}
