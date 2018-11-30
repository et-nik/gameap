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
            'steam_app_id' => 90
        ]);

        DB::table('games')->insert([
            'code' => 'cstrike',
            'start_code' => 'cstrike',
            'name' => 'Counter-Strike 1.6',
            'engine' => 'GoldSource',
            'engine_version' => '1',
            'steam_app_id' => 90,
        ]);

        DB::table('games')->insert([
            'code' => "czero",
            'start_code' => "czero",
            'name' => "Counter-Strike: Condition Zero",
            'engine' => "GoldSource",
            'engine_version' => "1",
            'steam_app_id' => "90",
            'steam_app_set_config' => "90 mod czero",
        ]);

        DB::table('games')->insert([
            'code' => 'svencoop',
            'start_code' => 'svencoop',
            'name' => 'Sven Co-op',
            'engine' => 'GoldSource',
            'engine_version' => '1',
            'steam_app_id' => 276060,
        ]);

        DB::table('games')->insert([
            'code' => 'minecraft',
            'start_code' => 'minecraft',
            'name' => 'Minecraft',
            'engine' => 'Minecraft',
            'engine_version' => '1',
        ]);
    }
}
