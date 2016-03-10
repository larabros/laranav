<?php

namespace Larabros\Laranav\Menus\Tests;

use Larabros\Laranav\Manager;
use Illuminate\Support\Collection;
use Larabros\Laranav\Tests\TestCase;
use \Mockery as m;

class ManagerTest extends TestCase
{
    /**
     * An example base application URL.
     */
    const BASE_URL = 'http://localhost';

    /**
     * @var Manager
     */
    protected $manager;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $app          = m::mock('Illuminate\Contracts\Foundation\Application');
        $request      = m::mock('Illuminate\Http\Request');
        $router       = m::mock('Illuminate\Contracts\Routing\Registrar');
        $urlGenerator = m::mock('Illuminate\Contracts\Routing\UrlGenerator');
        $viewFactory  = m::mock('Illuminate\Contracts\View\Factory');
        $config       = m::mock('Illuminate\Contracts\Config\Repository');

        $request->shouldReceive('is')->zeroOrMoreTimes()
            ->andReturn(true, false);

        $request->shouldReceive('root')->zeroOrMoreTimes()->andReturn(self::BASE_URL);

        $urlGenerator->shouldReceive('getRequest')
            ->zeroOrMoreTimes()->andReturn($request);
        $urlGenerator->shouldReceive('to')->zeroOrMoreTimes()
            ->andReturn(self::BASE_URL);

        $config->shouldReceive('get')
            ->with('laranav.config.default')
            ->zeroOrMoreTimes()
            ->andReturn([
                'active_class'   => 'active',
                'children_class' => 'dropdown',
                'view'           => 'laranav::partials.menu'
            ]);

        $config->shouldReceive('get')
            ->with('laranav.config.nav')
            ->zeroOrMoreTimes()
            ->andReturn(['view' => 'laranav::partials.nav']);

        $config->shouldReceive('get')
            ->with('laranav.menus.default')
            ->zeroOrMoreTimes()
            ->andReturn([
                'Home'    => '/',
                'About'   => 'about',
                'Contact' => 'contact',
            ]);

        $config->shouldReceive('get')
            ->with('laranav.menus.nav')
            ->zeroOrMoreTimes()
            ->andReturn([
                'Side Item 1' => '/side-1',
                'Side Item 2' => '/side-2',
            ]);

        $app->shouldReceive('make')
            ->with('config')
            ->zeroOrMoreTimes()
            ->andReturn($config);

        $app->shouldReceive('make')
            ->with('router')
            ->zeroOrMoreTimes()
            ->andReturn($router);

        $app->shouldReceive('make')
            ->with('url')
            ->zeroOrMoreTimes()
            ->andReturn($urlGenerator);

        $app->shouldReceive('make')
            ->with('view')
            ->zeroOrMoreTimes()
            ->andReturn($viewFactory);

        $this->manager = new Manager($app);
    }

    /**
     * @covers Larabros\Laranav\Manager::menu()
     * @covers Larabros\Laranav\Manager::getDefaultDriver()
     * @covers Larabros\Laranav\Manager::driver()
     * @covers Larabros\Laranav\Manager::createDriver()
     * @covers Larabros\Laranav\Manager::getConfig()
     * @covers Larabros\Laranav\Manager::getMenuItems()
     */
    public function testMenu()
    {
        $this->assertInstanceOf('Larabros\Laranav\Menus\Menu', $this->manager->menu());
        $this->assertCount(3, $this->manager->menu()->getItems());
    }

    /**
     * @covers Larabros\Laranav\Manager::menu()
     * @covers Larabros\Laranav\Manager::getDefaultDriver()
     * @covers Larabros\Laranav\Manager::driver()
     * @covers Larabros\Laranav\Manager::createDriver()
     * @covers Larabros\Laranav\Manager::getConfig()
     * @covers Larabros\Laranav\Manager::getMenuItems()
     */
    public function testDefaultMenuAndSecondaryMenu()
    {
        $this->assertInstanceOf('Larabros\Laranav\Menus\Menu', $this->manager->menu());
        $this->assertInstanceOf('Larabros\Laranav\Menus\Menu', $this->manager->menu('nav'));

        $this->assertCount(3, $this->manager->menu()->getItems());
        $this->assertCount(2, $this->manager->menu('nav')->getItems());
    }
}
