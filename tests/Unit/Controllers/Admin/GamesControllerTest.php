<?php

namespace Tests\Unit\Controllers\Admin;

use Gameap\Models\Game;
use Gameap\Repositories\GameRepository;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Container\Container;
use Gameap\Http\Controllers\Admin\GamesController;
use Illuminate\Http\Response;
use Gameap\Http\Requests\Admin\GameRequest;
use Mockery;

/**
 * @covers \Gameap\Http\Controllers\Admin\GamesController
 */
class GamesControllerTest extends TestCase
{
    /**
     * @var GamesController
     */
    protected $controller;

    /**
     * @var Container
     */
    protected $container;

    /**
     * @var \Mockery\MockInterface
     */
    protected $mock;

    /**
     * @var Game
     */
    protected $game;

    protected function setUp(): void
    {
        parent::setUp();

        $this->container = Container::getInstance();
        $this->mock = Mockery::mock(GameRepository::class)->makePartial();

        $this->container->instance(GameRepository::class, $this->mock);
        $this->controller = $this->container->make(GamesController::class);
        $this->game = Game::find('minecraft');
    }

    public function testIndex()
    {
        $response = $this->controller->index();
        $this->assertInstanceOf(\Illuminate\View\View::class, $response);
    }

    public function testCreate()
    {
        $response = $this->controller->create();
        $this->assertInstanceOf(\Illuminate\View\View::class, $response);
    }

    public function testEdit()
    {
        $response = $this->controller->edit($this->game);
        $this->assertInstanceOf(\Illuminate\View\View::class, $response);
    }

    public function testUpdate()
    {
        $request = GameRequest::create('/admin/games/', GameRequest::METHOD_PATCH, [
            'name' => 'MinecraftUpdated',
            'engine' => 'minecraft',
            'engine_version' => '1.0',
        ]);

        $response = $this->controller->update($request, $this->game);
        $this->assertEquals(Response::HTTP_FOUND, $response->getStatusCode());

        $game = Game::find('minecraft');
        $this->assertEquals('MinecraftUpdated', $game->name);
    }

    public function testShow()
    {
        $response = $this->controller->show($this->game);
        $this->assertInstanceOf(\Illuminate\View\View::class, $response);
    }

    public function testStore()
    {
        $request = GameRequest::create('/admin/games', GameRequest::METHOD_POST, [
            'code' => 'test_game',
            'name' => 'Test Game',
            'engine' => 'test',
            'engine_version' => '1.0',
        ]);

        $response = $this->controller->store($request);
        $this->assertEquals(Response::HTTP_FOUND, $response->getStatusCode());
    }

    public function testDestroy()
    {
        $game = Game::find('test_game');
        $response = $this->controller->destroy($game);
        $this->assertEquals(Response::HTTP_FOUND, $response->getStatusCode());
    }

    public function testUpgradeSuccess()
    {
        $this->mock->shouldReceive('upgradeFromRepo')->andReturn(true);
        $response = $this->controller->upgrade();
        $this->assertEquals(Response::HTTP_FOUND, $response->getStatusCode());
    }

    public function testUpgradeFail()
    {
        $this->mock->shouldReceive('upgradeFromRepo')->andReturn(false);
        $response = $this->controller->upgrade();
        $this->assertEquals(Response::HTTP_FOUND, $response->getStatusCode());
    }
}
