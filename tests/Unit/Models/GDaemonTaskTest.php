<?php

namespace Tests\Unit\Models;

use Gameap\Models\GdaemonTask;
use Gameap\Models\Server;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;

class GDaemonTaskTest extends TestCase
{
    public function testGetStatusNumAttribute()
    {
        factory(Server::class, 1)->create();
        factory(GdaemonTask::class, 1)->create();

        $gdaemonTask = GdaemonTask::first();
        
        $this->assertEquals($gdaemonTask->statusNum, GdaemonTask::NUM_STATUSES[$gdaemonTask->status]);
    }
}