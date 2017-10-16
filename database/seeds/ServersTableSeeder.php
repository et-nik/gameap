<?php

use Illuminate\Database\Seeder;

class ServersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('servers')->insert([
            'enabled' => 1,
            'installed' => 1,
            'blocked' => 0,
            'name' => 'Example Game Server',
            'code_name' => 'random_C0de',
            'game_id' => 'valve',
            'ds_id' => 1,
            'game_mod_id' => 1,
            'server_ip' => '127.0.0.1',
            'server_port' => 27015,
            'query_port' => 27015,
            'rcon_port' => 27015,
            'rcon' => 'rconPassword',
            'dir' => 'server01'
        ]);
    }
}
