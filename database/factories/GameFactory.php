<?php

namespace Database\Factories;

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Gameap\Models\Game;


$factory->define(Game::class, function (Faker $faker) {
    return [
        'code'          => 'test',
        'start_code'    => 'test',
        'name'          => 'Test',
        'engine'        => 'test',
        'engine_version' => '1.0',
    ];
});
