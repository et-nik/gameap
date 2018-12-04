<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DedicatedServersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('dedicated_servers')->insert([
            'enabled'               => 1,
            'name'                  => 'Example DS',
            'os'                    => 'linux',
            'location'              => 'Russia',
            'provider'              => 'GameAP',
            'ip'                    => '["127.0.0.1", "127.0.0.2"]',
            'work_path'             => '/home/servers',
            'steamcmd_path'         => '/home/servers/steamcmd',
            'gdaemon_host'          => '127.0.0.1',
            'gdaemon_port'          => 31717,
            'gdaemon_api_key'       => Str::random(64),
            'gdaemon_server_cert'   => '/path/to/server.crt',
            'client_certificate_id' => 1,
            'script_install'        => './script_install.sh',
            'script_reinstall'      => './script_reinstall.sh',
            'script_update'          => './script_update.sh',
            'script_start'          => './script_start.sh',
            'script_pause'          => './script_pause.sh',
            'script_stop'           => './script_stop.sh',
            'script_kill'           => './script_kill.sh',
            'script_restart'        => './script_restart.sh',
            'script_status'         => './script_status.sh',
            'script_get_console'    => './script_get_console.sh',
            'script_send_command'   => './script_send_command.sh',
            'script_delete'         => './script_delete.sh'
        ]);
    }
}
