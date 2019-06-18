<?php

namespace Tests\Unit\Models;

use Gameap\Models\GdaemonTask;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;

class GDaemonTaskTest extends TestCase
{
    public function testGetStatusNumAttribute()
    {
        factory(GdaemonTask::class, 1)->create();
        $gdaemonTask = GdaemonTask::first();
        
        $this->assertEquals($gdaemonTask->statusNum, GdaemonTask::NUM_STATUSES[$gdaemonTask->status]);
    }
}