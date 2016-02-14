<?php

namespace Laranav\Menus\Tests;

use Laranav\Menus\Menu;
use Laranav\Tests\TestCase;
use \Mockery as m;

class MenuTest extends TestCase
{
    /**
     * @var Menu
     */
    protected $menu;

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
     * @covers       Laranav\Menus\Menu::__construct()
     * @dataProvider menuProvider()
     */
    public function testGetName($itemData)
    {
    }

    /**
     * @covers       Laranav\Menus\Menu::__construct()
     * @dataProvider menuProvider()
     */
    public function testGetItems($itemData)
    {
    }

    /**
     * @dataProvider menuProvider()
     */
    public function testHasNoChildren($itemData)
    {
    }

    /**
     */
    public function testHasChildren()
    {
    }

    /**
     * Provides example menus.
     */
    public function menuProvider()
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
}
