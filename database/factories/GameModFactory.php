<?php

namespace Database\Factories;

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Gameap\Models\GameMod;
use Faker\Generator as Faker;

$factory->define(GameMod::class, function (Faker $faker) {
    $randomGameMod = GameMod::all()->random();

    return [
        'game_code'                     => $randomGameMod->game_code,
        'name'                          => $faker->name,
        'fast_rcon'                     => '',
        'vars'                          => '',
        'remote_repository_linux'       => 'https://example.com/mod_linux.tar.gz',
        'remote_repository_windows'     => 'https://example.com/mod_windows.zip',
        'local_repository_linux'        => 'path/to/mod_linux.tar.gz',
        'local_repository_windows'      => 'C:\\path\\to\\mod_windows.zip',
        'start_cmd_linux'               => './start.sh',
        'start_cmd_windows'             => 'start.exe',
        'kick_cmd'                      => '',
        'ban_cmd'                       => '',
        'chname_cmd'                    => '',
        'srestart_cmd'                  => '',
        'chmap_cmd'                     => '',
        'sendmsg_cmd'                   => '',
        'passwd_cmd'                    => '',
    ];
});
