<?php

namespace Laranav\Menus\Tests;

use Laranav\Menus\Item;
use Laranav\Menus\Menu;
use Laranav\Tests\TestCase;
use \Mockery as m;

class MenuTest extends TestCase
{
    /**
     * @var array
     */
    protected $config;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->config = [
            'active_class' => 'active',
            'children_class' => 'dropdown',
            'views' => [
                'menu' => 'laranav::partials.menu',
                'item' => 'laranav::partials.item',
            ]
        ];

        $this->requestMock = m::mock('Illuminate\Http\Request[is]');
        $this->generatorMock = m::mock('Illuminate\Contracts\Routing\UrlGenerator');
        $this->viewFactoryMock = m::mock('Illuminate\Contracts\View\Factory');
    }

    /**
     * @covers       Laranav\Menus\Menu::__construct()
     * @covers       Laranav\Menus\Menu::getName()
     * @dataProvider menuProvider()
     */
    public function testGetName($items)
    {
        $menu = new Menu('test', [], $this->config, $this->requestMock, $this->generatorMock, $this->viewFactoryMock);
        $this->assertEquals('test', $menu->getName());
    }

    /**
     * @covers       Laranav\Menus\Menu::__construct()
     * @covers       Laranav\Menus\Menu::addItems()
     * @covers       Laranav\Menus\Menu::createItems()
     * @covers       Laranav\Menus\Menu::isRouteItem()
     * @covers       Laranav\Menus\Menu::isNestedItem()
     * @covers       Laranav\Menus\Menu::isUrlActive()
     * @covers       Laranav\Menus\Menu::getItems()
     * @dataProvider menuProvider()
     */
    public function testAddItems($items)
    {
        $this->requestMock->shouldReceive('is')->times(3)->andReturn(true, false, false);
        $menu = new Menu('test', [], $this->config, $this->requestMock, $this->generatorMock, $this->viewFactoryMock);
        $menu->addItems($items);

        $this->assertCount(3, $menu->getItems());
        $this->assertContainsOnlyInstancesOf(Item::class, $menu->getItems()->toArray());
    }

    /**
     * @covers       Laranav\Menus\Menu::__construct()
     * @covers       Laranav\Menus\Menu::addItem()
     * @covers       Laranav\Menus\Menu::createItem()
     * @covers       Laranav\Menus\Menu::isRouteItem()
     * @covers       Laranav\Menus\Menu::isNestedItem()
     * @covers       Laranav\Menus\Menu::isUrlActive()
     * @covers       Laranav\Menus\Menu::getItems()
     * @dataProvider menuProvider()
     */
    public function testAddItem($items)
    {
        $this->requestMock->shouldReceive('is')->times(3)->andReturn(true, false, false);
        $menu = new Menu('test', [], $this->config, $this->requestMock, $this->generatorMock, $this->viewFactoryMock);

        foreach ($items as $title => $value) {
            $menu->addItem($title, $value);
        }

        $this->assertCount(3, $menu->getItems());
        $this->assertContainsOnlyInstancesOf(Item::class, $menu->getItems()->toArray());
    }

    /**
     * @covers       Laranav\Menus\Menu::__construct()
     * @covers       Laranav\Menus\Menu::addItems()
     * @covers       Laranav\Menus\Menu::createItems()
     * @covers       Laranav\Menus\Menu::isRouteItem()
     * @covers       Laranav\Menus\Menu::isNestedItem()
     * @covers       Laranav\Menus\Menu::isUrlActive()
     * @covers       Laranav\Menus\Menu::toHtml()
     * @covers       Laranav\Menus\Menu::getItems()
     * @dataProvider menuProvider()
     */
    public function testToHtml($items)
    {
        $output = '
<!DOCTYPE html>
<html>
    <head>
        <title>Laravel</title>
    </head>
    <body>
        <section class="sidebar">
  <ul class="sidebar-menu">
    <li class="header">MAIN NAVIGATION</li>
    <li class=" ">
  <a href="/">Home </a>
  </li>
<li class=" ">
  <a href="about">About </a>
  </li>
<li class=" ">
  <a href="contact">Contact </a>
  </li>
  </ul>
</section>

    </body>
</html>
';

        $this->requestMock->shouldReceive('is')->times(3)->andReturn(true, false, false);
        $viewMock = m::mock('Illuminate\Contracts\View\View');
        $viewMock->shouldReceive('render')->once()->andReturn($output);
        $this->viewFactoryMock->shouldReceive('make')->once()->andReturn($viewMock);
        $menu = new Menu('test', [], $this->config, $this->requestMock, $this->generatorMock, $this->viewFactoryMock);
        $menu->addItems($items);

        $this->assertEquals($output, $menu->toHtml());
    }

    /**
     * Provides example menus.
     */
    public function menuProvider()
    {
        return [
            [
                [
                    'Home'    => '/',
                    'About'   => 'about',
                    'Contact' => 'contact',
                ]
            ],
            [
                [
                    'Home'    => '/',
                    'About'   => 'about',
                    'Contact' => 'contact',
                ]
            ],
            [
                [
                    'Home'    => '/',
                    'About'   => 'about',
                    'Contact' => 'contact',
                ]
            ]
        ];
    }
}
