<?php

namespace Tests\Unit\Controllers\API;

use Tests\TestCase;

class HealthzControllerTest extends TestCase
{
    public function testIndex()
    {
        $response = $this->get('/api/healthz');

        $response->assertStatus(200);
    }
}
