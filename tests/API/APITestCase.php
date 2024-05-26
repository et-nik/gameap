<?php

namespace Tests\API;

use Illuminate\Container\Container;
use Tests\TestCase;

class APITestCase extends TestCase
{
    /** @var Container */
    protected $container;

    protected function setUp(): void
    {
        parent::setUp();

        $this->container = Container::getInstance();
    }
}
