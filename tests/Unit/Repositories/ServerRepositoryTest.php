<?php

namespace Tests\Unit\Repositories;

use Gameap\Repositories\ServerRepository;
use Illuminate\Container\Container;
use PHPUnit\Framework\Assert;
use Tests\TestCase;

class ServerRepositoryTest extends TestCase
{
    /** @var ServerRepository */
    protected $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $container = Container::getInstance();
        $this->repository = $container->make(ServerRepository::class);
    }

    public function testGetAll()
    {
        $servers = $this->repository->getAll();
        $serversCollection = $servers->items();
        Assert::assertNotNull($serversCollection);
    }
}
