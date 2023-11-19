<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
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

        /*
         *  Half life
         */

        DB::table('games')->insert([
            'code' => 'valve',
            'name' => 'Half-Life 1',
            'engine' => 'goldsource',
            'engine_version' => '1',
            'steam_app_id_linux' => 90,
            'steam_app_id_windows' => 90,
        ]);

        DB::table('games')->insert([
            'code' => 'op4',
            'name' => 'Half-Life: Opposing Force',
            'engine' => 'goldsource',
            'engine_version' => '1',
            'steam_app_id_linux' => 90,
            'steam_app_id_windows' => 90,
            'steam_app_set_config' => "90 mod gearbox",
        ]);

        DB::table('games')->insert([
            'code' => 'hl2mp',
            'name' => 'Half-Life 2',
            'engine' => 'source',
            'engine_version' => '1',
            'steam_app_id_linux' => 232370,
            'steam_app_id_windows' => 232370,
        ]);

        DB::table('games')->insert([
            'code' => 'bms',
            'name' => 'Black Mesa: Deathmatch',
            'engine' => 'source',
            'engine_version' => '4',
            'steam_app_id_linux' => 346680,
            'steam_app_id_windows' => 346680,
        ]);

        /*
         *  Counter Strike
         */

        DB::table('games')->insert([
            'code' => 'cs15',
            'name' => 'Counter-Strike 1.5',
            'engine' => 'goldsource',
            'engine_version' => '1',
        ]);

        DB::table('games')->insert([
            'code' => 'cstrike',
            'name' => 'Counter-Strike 1.6',
            'engine' => 'goldsource',
            'engine_version' => '1',
            'steam_app_id_linux' => 90,
            'steam_app_id_windows' => 90,
            'remote_repository_linux' => 'http://files.gameap.ru/cstrike-1.6/hlcs_base.tar.xz',
        ]);

        DB::table('games')->insert([
            'code' => "czero",
            'name' => "Counter-Strike: Condition Zero",
            'engine' => "goldsource",
            'engine_version' => "1",
            'steam_app_id_linux' => 90,
            'steam_app_id_windows' => 90,
            'steam_app_set_config' => "90 mod czero",
        ]);

        DB::table('games')->insert([
            'code' => "cssv34",
            'name' => "Counter-Strike: Source v34",
            'engine' => "source",
            'engine_version' => "34",
            'steam_app_id_linux' => 232330,
            'steam_app_id_windows' => 232330,
        ]);

        DB::table('games')->insert([
            'code' => "cssource",
            'name' => "Counter-Strike: Source",
            'engine' => "source",
            'engine_version' => "1",
            'steam_app_id_linux' => 232330,
            'steam_app_id_windows' => 232330,
        ]);

        DB::table('games')->insert([
            'code' => "csgo",
            'name' => "Counter-Strike: Global Offensive",
            'engine' => "source",
            'engine_version' => "1",
            'steam_app_id_linux' => 740,
            'steam_app_id_windows' => 740,
        ]);

        /*
         *  Counter Strike 2
         */

        DB::table('games')->insert([
            'code' => "cs2",
            'name' => "Counter-Strike 2",
            'engine' => "source",
            'engine_version' => "2",
            'steam_app_id_linux' => 730,
            'steam_app_id_windows' => 730,
        ]);

        /*
         *  Team Fortress
         */

        DB::table('games')->insert([
            'code' => 'tfc',
            'name' => 'Team Fortress Classic',
            'engine' => 'goldsource',
            'engine_version' => '1',
            'steam_app_id_linux' => 90,
            'steam_app_id_windows' => 90,
            'steam_app_set_config' => "90 mod tfc",
        ]);

        DB::table('games')->insert([
            'code' => 'tf2',
            'name' => 'Team Fortress 2',
            'engine' => 'source',
            'engine_version' => '1',
            'steam_app_id_linux' => 232250,
            'steam_app_id_windows' => 232250,
        ]);

        /*
         *  Day of Defeat
         */

        DB::table('games')->insert([
            'code' => 'dod',
            'name' => 'Day of Defeat',
            'engine' => 'goldsource',
            'engine_version' => '1',
            'steam_app_id_linux' => 90,
            'steam_app_id_windows' => 90,
            'steam_app_set_config' => "90 mod dod",
        ]);

        DB::table('games')->insert([
            'code' => 'dods',
            'name' => 'Day of Defeat: Source',
            'engine' => 'source',
            'engine_version' => '1',
            'steam_app_id_linux' => 232290,
            'steam_app_id_windows' => 232290,
        ]);

        /*
         *  Left 4 Dead
         */

        DB::table('games')->insert([
            'code' => 'l4d',
            'name' => 'Left 4 Dead',
            'engine' => 'source',
            'engine_version' => '1',
            'steam_app_id_linux' => 222840,
            'steam_app_id_windows' => 222840,
        ]);

        DB::table('games')->insert([
            'code' => 'l4d2',
            'name' => 'Left 4 Dead 2',
            'engine' => 'source',
            'engine_version' => '1',
            'steam_app_id_linux' => 222860,
            'steam_app_id_windows' => 222860,
        ]);

        /*
         *  Other gold source
         */

        DB::table('games')->insert([
            'code' => 'dmc',
            'name' => 'Deathmatch Classic',
            'engine' => 'goldsource',
            'engine_version' => '1',
            'steam_app_id_linux' => 90,
            'steam_app_id_windows' => 90,
            'steam_app_set_config' => "90 mod dmc",
        ]);

        DB::table('games')->insert([
            'code' => 'ricochet',
            'name' => 'Ricochet',
            'engine' => 'goldsource',
            'engine_version' => '1',
            'steam_app_id_linux' => 90,
            'steam_app_id_windows' => 90,
            'steam_app_set_config' => "90 mod ricochet",
        ]);

        DB::table('games')->insert([
            'code' => 'svencoop',
            'name' => 'Sven Co-op',
            'engine' => 'goldsource',
            'engine_version' => '1',
            'steam_app_id_linux' => 276060,
            'steam_app_id_windows' => 276060,
        ]);

        /*
         *  Other source
         */

        DB::table('games')->insert([
            'code' => 'insurgency',
            'name' => 'Insurgency',
            'engine' => 'source',
            'engine_version' => '1',
            'steam_app_id_linux' => 237410,
            'steam_app_id_windows' => 237410,
        ]);

        DB::table('games')->insert([
            'code' => 'garrysmod',
            'name' => 'Garry`s Mod',
            'engine' => 'source',
            'engine_version' => '1',
            'steam_app_id_linux' => 4020,
            'steam_app_id_windows' => 4020,
        ]);

        DB::table('games')->insert([
            'code' => 'pvk2',
            'name' => 'Pirates, Vikings, and Knights II',
            'engine' => 'source',
            'engine_version' => '1',
            'steam_app_id_linux' => 17575,
            'steam_app_id_windows' => 17575,
        ]);

        DB::table('games')->insert([
            'code' => 'nmrih',
            'name' => 'No More Room In Hell',
            'engine' => 'source',
            'engine_version' => '1',
            'steam_app_id_linux' => 317670,
            'steam_app_id_windows' => 317670,
        ]);

        DB::table('games')->insert([
            'code' => 'synergy',
            'name' => 'Synergy',
            'engine' => 'source',
            'engine_version' => '1',
            'steam_app_id_linux' => 17525,
            'steam_app_id_windows' => 17525,
        ]);

//        DB::table('games')->insert([
//            'code' => 'dota2',
//            'name' => 'Dota 2',
//            'engine' => 'Source',
//            'engine_version' => '1',
//            'steam_app_id_linux' => 570,
//        ]);

        /*
         *  Minecraft
         */

        DB::table('games')->insert([
            'code' => 'minecraft',
            'name' => 'Minecraft',
            'engine' => 'minecraft',
            'remote_repository_linux' => 'http://files.gameap.ru/minecraft/minecraft_install.tar.gz',
        ]);

        DB::table('games')->insert([
            'code' => 'pmmp',
            'name' => 'PocketMineMP (Minecraft PE)',
            'engine' => 'minecraft',
        ]);

        /*
         *  Arma
         */

        DB::table('games')->insert([
            'code' => 'arma2',
            'name' => 'Arma 2',
            'engine' => 'armedassault2',
            'engine_version' => '3',
            'steam_app_id_windows' => 33905,
        ]);

        DB::table('games')->insert([
            'code' => 'arma2oa',
            'name' => 'Arma 2: Operation Arrowhead',
            'engine' => 'armedassault2oa',
            'engine_version' => '3',
            'steam_app_id_windows' => 33935,
        ]);

        DB::table('games')->insert([
            'code' => 'arma3',
            'name' => 'Arma 3',
            'engine' => 'armedassault3',
            'engine_version' => '4',
            'steam_app_id_linux' => 233780,
            'steam_app_id_windows' => 233780,
        ]);

        /*
         *  Call of duty
         */

        DB::table('games')->insert([
            'code' => 'cod3',
            'name' => 'Call of Duty 3',
            'engine' => 'cod4',
            'steam_app_id_windows' => 42750,
        ]);

        DB::table('games')->insert([
            'code' => 'cod4',
            'name' => 'Call of Duty 4',
            'engine' => 'cod4',
            'engine_version' => '3.0',
        ]);

        /*
         *  GTA
         */

        DB::table('games')->insert([
            'code' => 'samp',
            'name' => 'SA-MP',
            'engine' => 'samp',
        ]);

        DB::table('games')->insert([
            'code' => 'mta',
            'name' => 'GTA: Multi Theft Auto',
            'engine' => 'mta',
            'remote_repository_linux' => 'http://files.gameap.ru/mta/mta.tar.xz',
        ]);

        DB::table('games')->insert([
            'code' => 'fivem',
            'name' => 'FiveM',
            'engine' => 'Gta5m',
            'remote_repository_linux' => 'http://files.gameap.ru/fivem/fivem.tar.xz',
        ]);

        DB::table('games')->insert([
            'code' => 'ragemp',
            'name' => 'RageMP',
            'engine' => 'Rage',
        ]);

        /*
         *  Just Cause
         */

        DB::table('games')->insert([
            'code' => 'justcause2',
            'name' => 'Just Cause 2',
            'engine' => 'AvalancheEngine',
            'engine_version' => '2.0',
            'steam_app_id_linux' => 261140,
            'steam_app_id_windows' => 261140,
        ]);

        DB::table('games')->insert([
            'code' => 'justcause3',
            'name' => 'Just Cause 3',
            'engine' => 'AvalancheEngine',
            'engine_version' => '3.0',
        ]);

        /*
         *  Killing Floor
         */

//        DB::table('games')->insert([
//            'code' => 'killingfloor',
//            'name' => 'Killing Floor',
//            'engine' => 'UnrealEngine',
//            'engine_version' => '2.5',
//            'steam_app_id_linux' => 215360,
//            'steam_app_id_windows' => 215350,
//        ]);

        DB::table('games')->insert([
            'code' => 'killingfloor2',
            'name' => 'Killing Floor 2',
            'engine' => 'UnrealEngine',
            'engine_version' => '3',
            'steam_app_id_linux' => 232130,
            'steam_app_id_windows' => 232130,
        ]);

        /*
         *  Other games
         */

        DB::table('games')->insert([
            'code' => 'ark',
            'name' => 'ARK: Survival Evolved',
            'engine' => 'Unreal Engine',
            'engine_version' => '4',
            'steam_app_id_linux' => 376030,
            'steam_app_id_windows' => 376030,
        ]);

        DB::table('games')->insert([
            'code' => 'rust',
            'name' => 'Rust',
            'engine' => 'Unity',
            'steam_app_id_windows' => 258550,
        ]);

        DB::table('games')->insert([
            'code' => 'hurtworld',
            'name' => 'HurtWorld',
            'engine' => 'Unity',
            'steam_app_id_linux' => 405100,
            'steam_app_id_windows' => 405100,
        ]);

        DB::table('games')->insert([
            'code' => '7d2d',
            'name' => '7 Days to Die',
            'engine' => 'Unity',
            'steam_app_id_linux' => 294420,
            'steam_app_id_windows' => 294420,
        ]);

        DB::table('games')->insert([
            'code' => 'the-forest',
            'name' => 'The Forest',
            'engine' => 'Unity',
            'steam_app_id_windows' => 556450,
        ]);

        DB::table('games')->insert([
            'code' => 'rok',
            'name' => 'Reign Of Kings',
            'engine' => 'Unity',
            'steam_app_id_windows' => 344760,
        ]);

        DB::table('games')->insert([
            'code' => 'dst',
            'name' => 'Don\'t Starve Together',
            'engine' => 'Don\'t Starve',
            'engine_version' => '1',
            'steam_app_id_linux' => 343050,
            'steam_app_id_windows' => 343050,
        ]);

        DB::table('games')->insert([
            'code' => 'teeworlds',
            'name' => 'Teeworlds',
            'engine' => 'Teeworlds',
        ]);

//        DB::table('games')->insert([
//            'code' => 'terraria',
//            'name' => 'Terraria',
//            'engine' => 'Terraria',
//            'steam_app_id_linux' => 105600,
//        ]);

//        DB::table('games')->insert([
//            'code' => 'unturned',
//            'name' => 'Unturned',
//            'engine' => 'Unturned',
//            'steam_app_id_linux' => 1110390,
//        ]);

        /*
         *  Software
         */

//        DB::table('games')->insert([
//            'code' => 'ts3',
//            'name' => 'TeamSpeak',
//            'engine' => 'TeamSpeak',
//        ]);

//        DB::table('games')->insert([
//            'code' => 'mumble',
//            'name' => 'Mumble',
//            'engine' => 'Mumble',
//        ]);
    }
}
