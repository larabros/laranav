<?php

namespace Laranav\Menus\Tests;

use Laranav\Manager;
use Illuminate\Support\Collection;
use Laranav\Tests\TestCase;
use \Mockery as m;

class ManagerTest extends TestCase
{
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

        $urlGenerator->shouldReceive('getRequest')
            ->zeroOrMoreTimes()->andReturn($request);

        $config->shouldReceive('get')
            ->with('laranav.config.default')
            ->zeroOrMoreTimes()
            ->andReturn([
                'active_class'   => 'active',
                'children_class' => 'dropdown',
                'views' => [
                    'menu' => 'laranav::partials.menu',
                    'item' => 'laranav::partials.item',
                ]
            ]);

        $config->shouldReceive('get')
            ->with('laranav.menus.default')
            ->zeroOrMoreTimes()
            ->andReturn([
                'Home'    => '/',
                'About'   => 'about',
                'Contact' => 'contact',
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
     * @covers Laranav\Manager::menu()
     * @covers Laranav\Manager::getDefaultDriver()
     * @covers Laranav\Manager::driver()
     * @covers Laranav\Manager::createDriver()
     * @covers Laranav\Manager::getConfig()
     * @covers Laranav\Manager::getMenuItems()
     */
    public function testMenu()
    {
        $this->assertInstanceOf('Laranav\Menus\Menu', $this->manager->menu());
    }
}
