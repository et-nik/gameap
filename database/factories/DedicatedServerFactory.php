<?php

namespace Database\Factories;

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Gameap\Models\ClientCertificate;
use Gameap\Models\DedicatedServer;

$factory->define(DedicatedServer::class, function (Faker $faker) {
    return [
        'enabled'               => 1,
        'name'                  => $faker->userName,
        'os'                    => 'linux',
        'location'              => $faker->country,
        'provider'              => $faker->company,
        'ip'                    => [$faker->ipv4],
        'ram'                   => '',
        'cpu'                   => '',
        'work_path'             => '/srv/gameap',
        'steamcmd_path'         => '/srv/gameap/steamcmd',
        'gdaemon_host'          => $faker->ipv4,
        'gdaemon_port'          => 31000,
        'gdaemon_api_key'       => sha1($faker->text(10)),
        'gdaemon_api_token'     => sha1($faker->text(10)),
        'gdaemon_login'         => '',
        'gdaemon_password'      => '',
        'gdaemon_server_cert'   => '',
        'client_certificate_id' => ClientCertificate::all()->random()->id,
        'prefer_install_method' => 'auto',
        'script_install'        => './script install',
        'script_reinstall'      => './script reinstall',
        'script_update'         => './script update',
        'script_start'          => './script start',
        'script_pause'          => './script pause',
        'script_unpause'        => './script unpause',
        'script_stop'           => './script stop',
        'script_kill'           => './script kill',
        'script_restart'        => './script restart',
        'script_status'         => './script status',
        'script_stats'          => './script stats',
        'script_get_console'    => './script get_console',
        'script_send_command'   => './script send_command',
        'script_delete'         => './script delete',
    ];
});
