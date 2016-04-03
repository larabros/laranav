<?php

namespace Larabros\Laranav\Menus\Tests;

use Larabros\Laranav\Menus\Item;
use Illuminate\Support\Collection;
use Larabros\Laranav\Tests\TestCase;
use \Mockery as m;

class ItemTest extends TestCase
{
    /**
     * @covers       Larabros\Laranav\Menus\Item::__construct()
     * @covers       Larabros\Laranav\Menus\Item::getTitle()
     * @dataProvider itemProvider()
     */
    public function testGetTitle($itemData)
    {
        list($title, $url) = $itemData;
        $item = new Item($title, $url);
        $this->assertEquals($title, $item->getTitle());
    }

    /**
     * @covers       Larabros\Laranav\Menus\Item::__construct()
     * @covers       Larabros\Laranav\Menus\Item::getUrl()
     * @dataProvider itemProvider()
     */
    public function testGetUrl($itemData)
    {
        list($title, $url) = $itemData;
        $item = new Item($title, $url);
        $this->assertEquals($url, $item->getUrl());
    }

    /**
     * @covers       Larabros\Laranav\Menus\Item::__construct()
     * @covers       Larabros\Laranav\Menus\Item::isActive()
     * @dataProvider itemProvider()
     */
    public function testGetIsActive($itemData)
    {
        list($title, $url) = $itemData;
        $item = new Item($title, $url, true);
        $this->assertTrue($item->isActive());
    }

    /**
     * @covers       Larabros\Laranav\Menus\Item::__construct()
     * @covers       Larabros\Laranav\Menus\Item::isActive()
     * @dataProvider itemProvider()
     */
    public function testGetIsInactive($itemData)
    {
        list($title, $url) = $itemData;
        $item = new Item($title, $url);
        $this->assertFalse($item->isActive());
    }

    /**
     * @covers       Larabros\Laranav\Menus\Item::__construct()
     * @covers       Larabros\Laranav\Menus\Item::hasChildren()
     * @covers       Larabros\Laranav\Menus\Item::getChildren()
     * @dataProvider itemProvider()
     */
    public function testGetNoChildren($itemData)
    {
        list($title, $url) = $itemData;
        $item = new Item($title, $url);

        $this->assertFalse($item->hasChildren());
        $this->assertCount(0, $item->getChildren());
    }

    /**
     * @covers       Larabros\Laranav\Menus\Item::__construct()
     * @covers       Larabros\Laranav\Menus\Item::hasChildren()
     * @covers       Larabros\Laranav\Menus\Item::getChildren()
     * @dataProvider nestedItemProvider()
     */
    public function testGetChildren($itemData)
    {
        list($title, $url, $isActive, $children) = $itemData;
        $item = new Item($title, $url, $isActive, $children);

        $this->assertCount(1, $item->getChildren());
        $this->assertContainsOnlyInstancesOf(Item::class, $item->getChildren()->toArray());
    }

    /**
     * @covers       Larabros\Laranav\Menus\Item::__construct()
     * @covers       Larabros\Laranav\Menus\Item::getClasses()
     * @dataProvider itemProvider()
     */
    public function testGetClasses($itemData)
    {
        list($title, $url) = $itemData;
        $item = new Item($title, $url);

        $this->assertEmpty($item->getClasses());
    }

    /**
     * @covers       Larabros\Laranav\Menus\Item::__construct()
     * @covers       Larabros\Laranav\Menus\Item::getClasses()
     * @dataProvider itemProvider()
     */
    public function testGetClassesWhenActive($itemData)
    {
        list($title, $url) = $itemData;
        $item = new Item($title, $url, true);

        $this->assertEquals('active', $item->getClasses());
    }

    /**
     * @covers       Larabros\Laranav\Menus\Item::__construct()
     * @covers       Larabros\Laranav\Menus\Item::getClasses()
     * @dataProvider nestedItemProvider()
     */
    public function testGetClassesWithChildren($itemData)
    {
        list($title, $url, $isActive, $children) = $itemData;
        $item = new Item($title, $url, $isActive, $children);

        $this->assertEquals('dropdown', $item->getClasses());
    }

    /**
     * @covers       Larabros\Laranav\Menus\Item::__construct()
     * @covers       Larabros\Laranav\Menus\Item::getClasses()
     * @dataProvider nestedItemProvider()
     */
    public function testGetClassesWhenActiveWithChildren($itemData)
    {
        list($title, $url, $isActive, $children) = $itemData;
        $item = new Item($title, $url, true, $children);

        $this->assertEquals('active dropdown', $item->getClasses());
    }

    /**
     * Provides example items.
     */
    public function itemProvider()
    {
        return [
            [
                ['Home', '/'],
            ],
            [
                ['About', 'about'],
            ],
            [
                ['Contact', 'contact'],
            ]
        ];
    }

    /**
     * Provides example items.
     */
    public function nestedItemProvider()
    {
        return [
            [
                ['Nested', '/', false, new Collection([new Item('Item1', '/nestedItem1')]) ],
            ]
        ];
    }
}
