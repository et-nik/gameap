<?php

namespace Database\Factories;

use Faker\Generator as Faker;
use Gameap\Models\Server;
use Gameap\Models\ServerTask;

/* @var $factory \Illuminate\Database\Eloquent\Factory */

$factory->define(ServerTask::class, function (Faker $faker) {
    return [
        'command'       => $faker->randomElement(['start', 'stop', 'restart', 'update']),
        'server_id'     => Server::all()->random()->id,
        'repeat'        => rand(0, 255),
        'repeat_period' => rand(600, 36000),
        'counter'       => rand(0, 5),
        'execute_date'  => date('Y-m-d H:i:s', time() + rand(600, 36000)),
        'payload'       => null,
    ];
});
