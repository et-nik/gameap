<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use DedicatedServersTableSeeder;
use ServersTableSeeder;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public static $initialized = false;

    protected function setUp(): void
    {
        parent::setUp();

        if (! self::$initialized) {
            self::$initialized = true;

            $this->seed(DedicatedServersTableSeeder::class);
            $this->seed(ServersTableSeeder::class);
        }
    }
}
