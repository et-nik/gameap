<?php

namespace Database\Factories;

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Gameap\Models\DedicatedServer;
use Gameap\Models\Server;
use Gameap\Models\GdaemonTask;
use Faker\Generator as Faker;

$factory->define(GdaemonTask::class, function (Faker $faker) {
    
    // $randomDsId = DedicatedServer::all()->random()->id;
    $randomServer = Server::all()->random();
    
    return [
        'dedicated_server_id' => $randomServer->ds_id,
        'server_id' => $randomServer->id,
        'task' => $faker->randomElement([
            GdaemonTask::TASK_SERVER_START,
            GdaemonTask::TASK_SERVER_STOP,
            GdaemonTask::TASK_SERVER_RESTART,
            GdaemonTask::TASK_SERVER_UPDATE,
            GdaemonTask::TASK_SERVER_INSTALL,
            GdaemonTask::TASK_SERVER_DELETE,
        ]),
        'data' => '',
        'cmd' => '',
        'output' => $faker->text,
        'status' => $faker->randomElement([
            GdaemonTask::STATUS_WAITING, 
            GdaemonTask::STATUS_WORKING, 
            GdaemonTask::STATUS_ERROR,
            GdaemonTask::STATUS_SUCCESS
        ]),
    ];
});
