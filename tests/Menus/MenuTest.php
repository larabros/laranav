<?php

namespace Laranav\Menus\Tests;

use Laranav\Menus\Item;
use Laranav\Menus\Menu;
use Laranav\Tests\TestCase;
use \Mockery as m;

class MenuTest extends TestCase
{
    /**
     * An example base application URL.
     */
    const BASE_URL = 'http://localhost';

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
            'active_class'   => 'active',
            'children_class' => 'dropdown',
            'view'           => 'laranav::partials.menu',
        ];

        $this->requestMock     = m::mock('Illuminate\Http\Request');
        $this->generatorMock   = m::mock('Illuminate\Contracts\Routing\UrlGenerator');
        $this->viewFactoryMock = m::mock('Illuminate\Contracts\View\Factory');

        $this->requestMock->shouldReceive('root')->zeroOrMoreTimes()->andReturn(self::BASE_URL);

        $this->generatorMock->shouldReceive('getRequest')->zeroOrMoreTimes()
            ->andReturn($this->requestMock);
        $this->generatorMock->shouldReceive('route')->zeroOrMoreTimes()
            ->andReturn(self::BASE_URL.'/', self::BASE_URL.'/about', self::BASE_URL.'/contact');
        $this->generatorMock->shouldReceive('to')->zeroOrMoreTimes()
            ->andReturn(self::BASE_URL.'/');
    }

    /**
     * @covers       Laranav\Menus\Menu::__construct()
     * @covers       Laranav\Menus\Menu::getName()
     * @dataProvider menuProvider()
     */
    public function testGetName($items)
    {
        $menu = new Menu('test', [], $this->config, $this->generatorMock, $this->viewFactoryMock);
        $this->assertEquals('test', $menu->getName());
    }

    /**
     * @covers       Laranav\Menus\Menu::__construct()
     * @covers       Laranav\Menus\Menu::addItems()
     * @covers       Laranav\Menus\Menu::createItems()
     * @covers       Laranav\Menus\Menu::createItem()
     * @covers       Laranav\Menus\Menu::isItemArray()
     * @covers       Laranav\Menus\Menu::hasNestedItems()
     * @covers       Laranav\Menus\Menu::generateItemUrl()
     * @covers       Laranav\Menus\Menu::isUrlActive()
     * @covers       Laranav\Menus\Menu::getItems()
     * @dataProvider menuProvider()
     */
    public function testAddItems($items)
    {
        $this->requestMock->shouldReceive('is')->times(3)->andReturn(true, false, false);
        $menu = new Menu('test', [], $this->config, $this->generatorMock, $this->viewFactoryMock);
        $menu->addItems($items);

        $this->assertCount(3, $menu->getItems());
        $this->assertContainsOnlyInstancesOf(Item::class, $menu->getItems()->toArray());
    }

    /**
     * @covers       Laranav\Menus\Menu::__construct()
     * @covers       Laranav\Menus\Menu::addItem()
     * @covers       Laranav\Menus\Menu::createItem()
     * @covers       Laranav\Menus\Menu::isItemArray()
     * @covers       Laranav\Menus\Menu::hasNestedItems()
     * @covers       Laranav\Menus\Menu::generateItemUrl()
     * @covers       Laranav\Menus\Menu::isUrlActive()
     * @covers       Laranav\Menus\Menu::getItems()
     * @dataProvider menuProvider()
     */
    public function testAddItem($items)
    {
        $this->requestMock->shouldReceive('is')->times(3)->andReturn(true, false, false);
        $menu = new Menu('test', [], $this->config, $this->generatorMock, $this->viewFactoryMock);

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
     * @covers       Laranav\Menus\Menu::createItem()
     * @covers       Laranav\Menus\Menu::isItemArray()
     * @covers       Laranav\Menus\Menu::hasNestedItems()
     * @covers       Laranav\Menus\Menu::generateItemUrl()
     * @covers       Laranav\Menus\Menu::isUrlActive()
     * @covers       Laranav\Menus\Menu::getItems()
     * @dataProvider nestedMenuProvider()
     */
    public function testAddNestedItems($items)
    {
        $this->requestMock->shouldReceive('is')->times(4)->andReturn(true, false, false);
        $menu = new Menu('test', [], $this->config, $this->generatorMock, $this->viewFactoryMock);
        $menu->addItems($items);

        $this->assertCount(2, $menu->getItems());
        $this->assertCount(2, $menu->getItems()->last()->getChildren());
        $this->assertContainsOnlyInstancesOf(Item::class, $menu->getItems()->toArray());
        $this->assertContainsOnlyInstancesOf(Item::class, $menu->getItems()->last()->getChildren()->toArray());
    }

    /**
     * @covers       Laranav\Menus\Menu::__construct()
     * @covers       Laranav\Menus\Menu::addItems()
     * @covers       Laranav\Menus\Menu::createItems()
     * @covers       Laranav\Menus\Menu::isItemArray()
     * @covers       Laranav\Menus\Menu::hasNestedItems()
     * @covers       Laranav\Menus\Menu::generateItemUrl()
     * @covers       Laranav\Menus\Menu::isUrlActive()
     * @covers       Laranav\Menus\Menu::toHtml()
     * @covers       Laranav\Menus\Menu::getItems()
     * @dataProvider menuProvider()
     */
    public function testToHtml($items)
    {
        $this->requestMock->shouldReceive('is')->times(3)->andReturn(true, false, false);

        $viewMock = m::mock('Illuminate\Contracts\View\View');
        $viewMock->shouldReceive('render')->once()->andReturn($this->getSimpleOutput());
        $this->viewFactoryMock->shouldReceive('make')->once()->andReturn($viewMock);
        $menu = new Menu('test', [], $this->config, $this->generatorMock, $this->viewFactoryMock);
        $menu->addItems($items);

        $this->assertEquals($this->getSimpleOutput(), $menu->toHtml());
    }

    /**
     * @covers       Laranav\Menus\Menu::__construct()
     * @covers       Laranav\Menus\Menu::addItems()
     * @covers       Laranav\Menus\Menu::createItems()
     * @covers       Laranav\Menus\Menu::isItemArray()
     * @covers       Laranav\Menus\Menu::hasNestedItems()
     * @covers       Laranav\Menus\Menu::generateItemUrl()
     * @covers       Laranav\Menus\Menu::isUrlActive()
     * @covers       Laranav\Menus\Menu::toHtml()
     * @covers       Laranav\Menus\Menu::getItems()
     * @dataProvider nestedMenuProvider()
     */
    public function testToHtmlWithNestedItems($items)
    {
        $this->requestMock->shouldReceive('is')->times(8)->andReturn(true, false, false);

        $generatorMock   = m::mock('Illuminate\Contracts\Routing\UrlGenerator');
        $generatorMock->shouldReceive('getRequest')->zeroOrMoreTimes()
            ->andReturn($this->requestMock);
        $generatorMock->shouldReceive('route')->zeroOrMoreTimes()
            ->andReturn(self::BASE_URL.'/', self::BASE_URL.'/', self::BASE_URL.'/item1', self::BASE_URL.'/item2');
        $generatorMock->shouldReceive('to')->zeroOrMoreTimes()
            ->andReturn(self::BASE_URL.'/');

        $viewMock = m::mock('Illuminate\Contracts\View\View');
        $viewMock->shouldReceive('render')->once()->andReturn($this->getNestedOutput());
        $this->viewFactoryMock->shouldReceive('make')->once()->andReturn($viewMock);
        $menu = new Menu('test', $items, $this->config, $generatorMock, $this->viewFactoryMock);
        $menu->addItems($items);

        $this->assertEquals($this->getNestedOutput(), $menu->toHtml());
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
                    'Home'    => ['route' => 'home'],
                    'About'   => ['route' => 'about'],
                    'Contact' => ['route' => 'contact'],
                ]
            ]
        ];
    }

    /**
     * Provides example menus.
     */
    public function nestedMenuProvider()
    {
        return [
            [
                [
                    'Home'     => '/',
                    'Dropdown' => [
                        'default' => '/',
                        'Item 1' => 'item1',
                        'Item 2' => 'item2',
                    ]
                ],
            ],
            [
                [
                    'Home'     => '/',
                    'Dropdown' => [
                        'default' => ['to' => '/'],
                        'Item 1' =>  ['route' => 'item1'],
                        'Item 2' =>  ['route' => 'item2'],
                    ]
                ]
            ]
        ];
    }

    private function getSimpleOutput()
    {
        return file_get_contents(__DIR__ . '/../fixtures/simple.html');
    }

    private function getNestedOutput()
    {
        return file_get_contents(__DIR__ . '/../fixtures/nested.html');
    }
}
