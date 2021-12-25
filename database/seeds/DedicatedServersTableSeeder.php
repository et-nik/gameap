<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

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
            'gdaemon_api_key'       => 'gdaemon_test_api_key',
            'gdaemon_server_cert'   => 'certs/root.crt',
            'client_certificate_id' => 1,
            'script_install'        => './server.sh install {uuid_short}',
            'script_reinstall'      => './server.sh reinstall {uuid_short}',
            'script_update'         => './server.sh update {uuid_short}',
            'script_start'          => './server.sh start {uuid_short}',
            'script_pause'          => './server.sh pause {uuid_short}',
            'script_unpause'        => './server.sh unpause {uuid_short}',
            'script_stop'           => './server.sh stop {uuid_short}',
            'script_kill'           => './server.sh kill {uuid_short}',
            'script_restart'        => './server.sh restart {uuid_short}',
            'script_status'         => './server.sh status {uuid_short}',
            'script_stats'          => './server.sh stats {uuid_short}',
            'script_get_console'    => './server.sh console {uuid_short}',
            'script_send_command'   => './server.sh send_command {uuid_short} "{command}"',
            'script_delete'         => './server.sh delete {uuid_short}'
        ]);
    }
}
