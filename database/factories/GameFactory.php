<?php

namespace Database\Factories;

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Gameap\Models\Game;


$factory->define(Game::class, function (Faker $faker) {
    return [
        'code'          => 'test_' . $faker->lexify(),
        'name'          => $faker->unique()->words(3, true),
        'engine'        => 'test',
        'engine_version' => '1.0',
        'remote_repository_linux' => '',
    ];
});
