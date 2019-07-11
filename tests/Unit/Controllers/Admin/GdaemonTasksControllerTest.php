<?php

namespace Tests\Unit\Controllers\Admin;

use Tests\TestCase;
use Gameap\Models\GdaemonTask;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Container\Container;
use Gameap\Http\Controllers\Admin\GdaemonTasksController;
use Illuminate\Http\Response;

/**
 * @covers \Gameap\Http\Controllers\Admin\GdaemonTasksController<extended>
 */
class GdaemonTasksControllerTest extends TestCase
{
    /**
     * @var GdaemonTasksController
     */
    protected $controller;

    /**
     * @var Container
     */
    protected $container;

    /**
     * @var GdaemonTask
     */
    protected $gdaemonTask;

    protected function setUp(): void
    {
        parent::setUp();

        $this->container = Container::getInstance();
        $this->controller = $this->container->make(GdaemonTasksController::class);
    }

    public function testIndex()
    {
        $response = $this->controller->index();
        $this->assertInstanceOf(\Illuminate\View\View::class, $response);
    }

    public function testShow()
    {
        $gdaemonTask = new GdaemonTask();
        $response = $this->controller->show($gdaemonTask);
        $this->assertInstanceOf(\Illuminate\View\View::class, $response);
    }
}
