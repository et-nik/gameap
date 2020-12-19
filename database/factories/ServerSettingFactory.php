<?php

namespace Database\Factories;

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Gameap\Models\ServerSetting;
use Gameap\Models\Server;
use Faker\Generator as Faker;

$factory->define(ServerSetting::class, function (Faker $faker) {
    return [
        'name' => $faker->slug(1),
        'server_id' => Server::all()->random()->id,
        'value' => $faker->sha256,
    ];
});
