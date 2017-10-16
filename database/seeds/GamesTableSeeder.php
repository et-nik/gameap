<?php

use Illuminate\Database\Seeder;

class GamesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('games')->insert([
            'code' => 'valve',
            'start_code' => 'valve',
            'name' => 'Half-Life 1',
            'engine' => 'GoldSource',
            'engine_version' => '1',
            'steam_app_id' => '90',
            'steam_app_set_config' => '',
            'local_repository' => '',
            'remote_repository' => '',
        ]);
    }
}
