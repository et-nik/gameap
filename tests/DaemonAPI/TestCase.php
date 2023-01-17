<?php

namespace Tests\DaemonAPI;

use Illuminate\Container\Container;
use Tests\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    /** @var Container */
    protected $container;

    protected function setUp(): void
    {
        parent::setUp();

        $this->container = Container::getInstance();
    }
}
