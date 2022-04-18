<?php

namespace Database\Seeders;

use DB;
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
        $gapRepoBaseUrl = 'http://files.gameap.ru';

        DB::table('games')->insert([
            'code' => 'valve',
            'start_code' => 'valve',
            'name' => 'Half-Life 1',
            'engine' => 'GoldSource',
            'engine_version' => '1',
            'steam_app_id' => 90,
        ]);

        DB::table('games')->insert([
            'code' => 'hl2mp',
            'start_code' => 'hl2mp',
            'name' => 'Half-Life 2',
            'engine' => 'Source',
            'engine_version' => '1',
            'steam_app_id' => 232370,
        ]);

        DB::table('games')->insert([
            'code' => 'op4',
            'start_code' => 'gearbox',
            'name' => 'Half-Life: Opposing Force',
            'engine' => 'GoldSource',
            'engine_version' => '1',
            'steam_app_id' => 90,
            'steam_app_set_config' => "90 mod gearbox",
        ]);

        DB::table('games')->insert([
            'code' => 'dmc',
            'start_code' => 'dmc',
            'name' => 'Deathmatch Classic',
            'engine' => 'GoldSource',
            'engine_version' => '1',
            'steam_app_id' => 90,
            'steam_app_set_config' => "90 mod dmc",
        ]);

        DB::table('games')->insert([
            'code' => 'ricochet',
            'start_code' => 'ricochet',
            'name' => 'Ricochet',
            'engine' => 'GoldSource',
            'engine_version' => '1',
            'steam_app_id' => 90,
            'steam_app_set_config' => "90 mod ricochet",
        ]);

        DB::table('games')->insert([
            'code' => 'cs15',
            'start_code' => 'cstrike',
            'name' => 'Counter-Strike 1.5',
            'engine' => 'GoldSource',
            'engine_version' => '1',
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
            'steam_app_id' => 90,
            'steam_app_set_config' => "90 mod czero",
        ]);

        DB::table('games')->insert([
            'code' => "cssv34",
            'start_code' => "cstrike",
            'name' => "Counter-Strike: Source v34",
            'engine' => "Source",
            'engine_version' => "34",
            'steam_app_id' => 232330,
        ]);

        DB::table('games')->insert([
            'code' => "cssource",
            'start_code' => "cstrike",
            'name' => "Counter-Strike: Source",
            'engine' => "Source",
            'engine_version' => "1",
            'steam_app_id' => 232330,
        ]);

        DB::table('games')->insert([
            'code' => "csgo",
            'start_code' => "csgo",
            'name' => "Counter-Strike: Global Offensive",
            'engine' => "Source",
            'engine_version' => "1",
            'steam_app_id' => 740,
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
            'code' => 'dod',
            'start_code' => 'dod',
            'name' => 'Day of Defeat',
            'engine' => 'GoldSource',
            'engine_version' => '1',
            'steam_app_id' => 90,
            'steam_app_set_config' => "90 mod dod",
        ]);

        DB::table('games')->insert([
            'code' => 'dods',
            'start_code' => 'dods',
            'name' => 'Day of Defeat: Source',
            'engine' => 'Source',
            'engine_version' => '1',
            'steam_app_id' => 232290,
        ]);

        DB::table('games')->insert([
            'code' => 'tfc',
            'start_code' => 'tfc',
            'name' => 'Team Fortress Classic',
            'engine' => 'GoldSource',
            'engine_version' => '1',
            'steam_app_id' => 90,
            'steam_app_set_config' => "90 mod tfc",
        ]);

        DB::table('games')->insert([
            'code' => 'tf2',
            'start_code' => 'tf',
            'name' => 'Team Fortress 2',
            'engine' => 'Source',
            'engine_version' => '1',
            'steam_app_id' => 232250,
        ]);

        DB::table('games')->insert([
            'code' => 'insurgency',
            'start_code' => 'insurgency',
            'name' => 'Insurgency',
            'engine' => 'Source',
            'engine_version' => '1',
            'steam_app_id' => 237410,
        ]);

        DB::table('games')->insert([
            'code' => 'synergy',
            'start_code' => 'synergy',
            'name' => 'Synergy',
            'engine' => 'Source',
            'engine_version' => '1',
            'steam_app_id' => 17525,
        ]);
        
        DB::table('games')->insert([
            'code' => 'garrysmod',
            'start_code' => 'garrysmod',
            'name' => 'Garry`s Mod',
            'engine' => 'Source',
            'engine_version' => '1',
            'steam_app_id' => 4020,
        ]);

        DB::table('games')->insert([
            'code' => 'bms',
            'start_code' => 'bms',
            'name' => 'Black Mesa: Deathmatch',
            'engine' => 'Source',
            'engine_version' => '4',
            'steam_app_id' => 346680,
        ]);

        DB::table('games')->insert([
            'code' => 'l4d',
            'start_code' => 'l4d',
            'name' => 'Left 4 Dead',
            'engine' => 'Source',
            'engine_version' => '1',
            'steam_app_id' => 222840,
        ]);

        DB::table('games')->insert([
            'code' => 'l4d2',
            'start_code' => 'l4d2',
            'name' => 'Left 4 Dead 2',
            'engine' => 'Source',
            'engine_version' => '1',
            'steam_app_id' => 222860,
        ]);

        DB::table('games')->insert([
            'code' => 'ark',
            'start_code' => 'ark',
            'name' => 'ARK: Survival Evolved',
            'engine' => 'Source',
            'engine_version' => '1',
            'steam_app_id' => 376030,
        ]);
        
        DB::table('games')->insert([
            'code' => 'minecraft',
            'start_code' => 'minecraft',
            'name' => 'Minecraft',
            'engine' => 'Minecraft',
            'remote_repository' => $gapRepoBaseUrl . '/minecraft/minecraft_install.tar.gz',
        ]);

        DB::table('games')->insert([
            'code' => 'pmmp',
            'start_code' => 'pmmp',
            'name' => 'PocketMineMP (Minecraft PE)',
            'engine' => 'Minecraft',
            'remote_repository' => 'https://github.com/pmmp/PocketMine-MP/releases/download/4.2.7/PocketMine-MP.phar',
        ]);
        
        DB::table('games')->insert([
            'code' => 'rust',
            'start_code' => 'rust',
            'name' => 'Rust',
            'engine' => 'Unity',
            'steam_app_id' => 258550,
        ]);
        
        DB::table('games')->insert([
            'code' => 'hurtworld',
            'start_code' => 'hurtworld',
            'name' => 'HurtWorld',
            'engine' => 'Unity',
            'steam_app_id' => 405100,
        ]);

        DB::table('games')->insert([
            'code' => 'arma2',
            'start_code' => 'arma2',
            'name' => 'Arma 2',
            'engine' => 'RealVirtuality',
            'engine_version' => '3',
            'steam_app_id' => 33905,
        ]);
        
        DB::table('games')->insert([
            'code' => 'arma2oa',
            'start_code' => 'arma2oa',
            'name' => 'Arma 2: Operation Arrowhead',
            'engine' => 'RealVirtuality',
            'engine_version' => '3',
            'steam_app_id' => 33935,
        ]);
        
        DB::table('games')->insert([
            'code' => 'arma3',
            'start_code' => 'arma3',
            'name' => 'Arma 3',
            'engine' => 'RealVirtuality',
            'engine_version' => '4',
            'steam_app_id' => 233780,
        ]);
        
        DB::table('games')->insert([
            'code' => 'cod4',
            'start_code' => 'cod4',
            'name' => 'Call of Duty 4',
            'engine' => 'IWEngine',
            'engine_version' => '3.0'
        ]);
        
        DB::table('games')->insert([
            'code' => 'mta',
            'start_code' => 'mta',
            'name' => 'GTA: Multi Theft Auto',
            'engine' => 'RenderWare',
            'remote_repository' => $gapRepoBaseUrl . '/mta/mta.tar.xz',
        ]);
        
        DB::table('games')->insert([
            'code' => 'samp',
            'start_code' => 'samp',
            'name' => 'SA-MP',
            'engine' => 'RenderWare',
        ]);

        DB::table('games')->insert([
            'code' => 'fivem',
            'start_code' => 'fivem',
            'name' => 'FiveM',
            'engine' => 'Rage',
            'remote_repository' => $gapRepoBaseUrl . '/fivem/fivem.tar.xz',
        ]);

        DB::table('games')->insert([
            'code' => 'justcause2',
            'start_code' => 'justcause2',
            'name' => 'Just Cause 2',
            'engine' => 'AvalancheEngine',
            'engine_version' => '2.0',
            'steam_app_id' => 261140,
        ]);

        DB::table('games')->insert([
            'code' => 'justcause3',
            'start_code' => 'justcause3',
            'name' => 'Just Cause 3',
            'engine' => 'AvalancheEngine',
            'engine_version' => '3.0',
            'steam_app_id' => 619960,
        ]);

        DB::table('games')->insert([
            'code' => '7d2d',
            'start_code' => '7d2d',
            'name' => '7 Days to Die',
            'engine' => 'Unity',
            'steam_app_id' => 294420,
        ]);

        DB::table('games')->insert([
            'code' => 'killingfloor',
            'start_code' => 'killingfloor',
            'name' => 'Killing Floor',
            'engine' => 'UnrealEngine',
            'engine_version' => '2.5',
            'steam_app_id' => 232130,
        ]);

        DB::table('games')->insert([
            'code' => 'killingfloor2',
            'start_code' => 'killingfloor2',
            'name' => 'Killing Floor 2',
            'engine' => 'UnrealEngine',
            'engine_version' => '3',
            'steam_app_id' => 232130,
        ]);

        DB::table('games')->insert([
            'code' => 'the-forest',
            'start_code' => 'the-forest',
            'name' => 'The Forest',
            'engine' => 'Unity',
            'steam_app_id' => 556450,
        ]);

        DB::table('games')->insert([
            'code' => 'rok',
            'start_code' => 'rok',
            'name' => 'Reign Of Kings',
            'engine' => 'Unity',
            'steam_app_id' => 344760,
        ]);

        DB::table('games')->insert([
            'code' => 'ts3',
            'start_code' => 'ts3',
            'name' => 'TeamSpeak',
            'engine' => 'TeamSpeak',
        ]);

        DB::table('games')->insert([
            'code' => 'mumble',
            'start_code' => 'mumble',
            'name' => 'Mumble',
            'engine' => 'Mumble',
        ]);
    }
}
