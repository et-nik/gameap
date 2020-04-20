<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Gameap\Models\Server;
use Gameap\Models\GameMod;
use Gameap\Models\DedicatedServer;
use Faker\Generator as Faker;

$factory->define(Server::class, function (Faker $faker) {
    $uuid = $faker->uuid;
    $randomGameMod = GameMod::all()->random();
    $dedicatedServer = DedicatedServer::all()->random();
    
    return [
        'enabled' => $faker->numberBetween(0, 1),
        'installed' => $faker->numberBetween(0, 1),
        'blocked' => $faker->numberBetween(0, 1),
        'name' => $randomGameMod->game->name . ' ' . $randomGameMod->name,
        'uuid' => $uuid,
        'uuid_short' => substr($uuid, 0, 8),
        'game_id' => $randomGameMod->game_code,
        'ds_id' => $dedicatedServer->id,
        'game_mod_id' => $randomGameMod->id,
        'expires' => $faker->date,
        'server_ip' => $faker->randomElement($dedicatedServer->ip),
        'server_port' => $faker->numberBetween(25000, 28000),
        'query_port' => $faker->numberBetween(25000, 28000),
        'rcon_port' => $faker->numberBetween(25000, 28000),
        'rcon' => $faker->password,
        'dir' => 'servers/' . $randomGameMod->game_code . '_' . $faker->numberBetween(1, 99999),
        'su_user' => 'gameap',
        'process_active' => $faker->boolean,
        'last_process_check' => date('Y-m-d H:i:s', time()),
        'vars' => [],
    ];
});
