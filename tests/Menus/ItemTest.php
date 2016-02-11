<?php

namespace Laranav\Menus\Tests;

use Laranav\Menus\Item;
use Illuminate\Support\Collection;

class ItemTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Item
     */
    protected $item;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {}

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {}

    /**
     * Test that true does in fact equal true
     */
    public function testTrueIsTrue() {
        $this->assertTrue(true);
    }

    /**
     * @covers       Laranav\Menus\Item::__construct()
     * @covers       Laranav\Menus\Item::getTitle()
     * @dataProvider itemProvider()
     */
    public function testGetTitle($itemData)
    {
        list($title, $url) = $itemData;
        $item = new Item($title, $url);
        $this->assertEquals($title, $item->getTitle());
    }

    /**
     * @covers       Laranav\Menus\Item::__construct()
     * @covers       Laranav\Menus\Item::getUrl()
     * @dataProvider itemProvider()
     */
    public function testGetUrl($itemData)
    {
        list($title, $url) = $itemData;
        $item = new Item($title, $url);
        $this->assertEquals($url, $item->getUrl());
    }

    /**
     * @covers       Laranav\Menus\Item::hasChildren()
     * @dataProvider itemProvider()
     */
    public function testHasNoChildren($itemData)
    {
        list($title, $url) = $itemData;
        $item = new Item($title, $url);
        $this->assertFalse($item->hasChildren());
    }

    /**
     * @covers       Laranav\Menus\Item::hasChildren()
     * @dataProvider nestedItemProvider()
     */
    public function testHasChildren($itemData)
    {
        list($title, $url, $isActive, $children) = $itemData;
        $item = new Item($title, $url, $isActive, $children);
        $this->assertTrue($item->hasChildren());
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
                ['Nested', '/', false, new Collection(['Item1' => '/nestedItem1']) ],
            ]
        ];
    }
}
