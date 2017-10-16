<?php

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
            'gdaemon_login'         => 'gdaemon_login',
            'gdaemon_password'      => 'gdaemon_password',
            'gdaemon_privkey'       => 'gdaemon_privkey',
            'gdaemon_pubkey'        => 'gdaemon_pubkey',
            'gdaemon_keypass'       => 'gdaemon_keypass',
            'gdaemon_keypass'       => 'gdaemon_keypass',
            'script_start'          => 'script_start',
            'script_stop'           => 'script_stop',
            'script_restart'        => 'script_restart',
            'script_status'         => 'script_status',
            'script_get_console'    => 'script_get_console',
            'script_send_command'   => 'script_send_command'
        ]);
    }
}
