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

        /*
         *  Half life
         */

        DB::table('games')->insert([
            'code' => 'valve',
            'start_code' => 'valve',
            'name' => 'Half-Life 1',
            'engine' => 'GoldSource',
            'engine_version' => '1',
            'steam_app_id_nix' => 90,
            'steam_app_id_win' => 90,
        ]);

        DB::table('games')->insert([
            'code' => 'op4',
            'start_code' => 'gearbox',
            'name' => 'Half-Life: Opposing Force',
            'engine' => 'GoldSource',
            'engine_version' => '1',
            'steam_app_id_nix' => 90,
            'steam_app_id_win' => 90,
            'steam_app_set_config' => "90 mod gearbox",
        ]);

        DB::table('games')->insert([
            'code' => 'hl2mp',
            'start_code' => 'hl2mp',
            'name' => 'Half-Life 2',
            'engine' => 'Source',
            'engine_version' => '1',
            'steam_app_id_nix' => 232370,
            'steam_app_id_win' => 232370,
        ]);

        DB::table('games')->insert([
            'code' => 'bms',
            'start_code' => 'bms',
            'name' => 'Black Mesa: Deathmatch',
            'engine' => 'Source',
            'engine_version' => '4',
            'steam_app_id_nix' => 346680,
            'steam_app_id_win' => 346680,
        ]);

        /*
         *  Counter Strike
         */

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
            'steam_app_id_nix' => 90,
            'steam_app_id_win' => 90,
        ]);

        DB::table('games')->insert([
            'code' => "czero",
            'start_code' => "czero",
            'name' => "Counter-Strike: Condition Zero",
            'engine' => "GoldSource",
            'engine_version' => "1",
            'steam_app_id_nix' => 90,
            'steam_app_id_win' => 90,
            'steam_app_set_config' => "90 mod czero",
        ]);

        DB::table('games')->insert([
            'code' => "cssv34",
            'start_code' => "cstrike",
            'name' => "Counter-Strike: Source v34",
            'engine' => "Source",
            'engine_version' => "34",
            'steam_app_id_nix' => 232330,
            'steam_app_id_win' => 232330,
        ]);

        DB::table('games')->insert([
            'code' => "cssource",
            'start_code' => "cstrike",
            'name' => "Counter-Strike: Source",
            'engine' => "Source",
            'engine_version' => "1",
            'steam_app_id_nix' => 232330,
            'steam_app_id_win' => 232330,
        ]);

        DB::table('games')->insert([
            'code' => "csgo",
            'start_code' => "csgo",
            'name' => "Counter-Strike: Global Offensive",
            'engine' => "Source",
            'engine_version' => "1",
            'steam_app_id_nix' => 740,
            'steam_app_id_win' => 740,
        ]);

        /*
         *  Team Fortress
         */

        DB::table('games')->insert([
            'code' => 'tfc',
            'start_code' => 'tfc',
            'name' => 'Team Fortress Classic',
            'engine' => 'GoldSource',
            'engine_version' => '1',
            'steam_app_id_nix' => 90,
            'steam_app_id_win' => 90,
            'steam_app_set_config' => "90 mod tfc",
        ]);

        DB::table('games')->insert([
            'code' => 'tf2',
            'start_code' => 'tf',
            'name' => 'Team Fortress 2',
            'engine' => 'Source',
            'engine_version' => '1',
            'steam_app_id_nix' => 232250,
            'steam_app_id_win' => 232250,
        ]);

        /*
         *  Day of Defeat
         */

        DB::table('games')->insert([
            'code' => 'dod',
            'start_code' => 'dod',
            'name' => 'Day of Defeat',
            'engine' => 'GoldSource',
            'engine_version' => '1',
            'steam_app_id_nix' => 90,
            'steam_app_id_win' => 90,
            'steam_app_set_config' => "90 mod dod",
        ]);

        DB::table('games')->insert([
            'code' => 'dods',
            'start_code' => 'dods',
            'name' => 'Day of Defeat: Source',
            'engine' => 'Source',
            'engine_version' => '1',
            'steam_app_id_nix' => 232290,
            'steam_app_id_win' => 232290,
        ]);

        /*
         *  Left 4 Dead
         */

        DB::table('games')->insert([
            'code' => 'l4d',
            'start_code' => 'l4d',
            'name' => 'Left 4 Dead',
            'engine' => 'Source',
            'engine_version' => '1',
            'steam_app_id_nix' => 222840,
            'steam_app_id_win' => 222840,
        ]);

        DB::table('games')->insert([
            'code' => 'l4d2',
            'start_code' => 'l4d2',
            'name' => 'Left 4 Dead 2',
            'engine' => 'Source',
            'engine_version' => '1',
            'steam_app_id_nix' => 222860,
            'steam_app_id_win' => 222860,
        ]);

        /*
         *  Other gold source
         */

        DB::table('games')->insert([
            'code' => 'dmc',
            'start_code' => 'dmc',
            'name' => 'Deathmatch Classic',
            'engine' => 'GoldSource',
            'engine_version' => '1',
            'steam_app_id_nix' => 90,
            'steam_app_id_win' => 90,
            'steam_app_set_config' => "90 mod dmc",
        ]);

        DB::table('games')->insert([
            'code' => 'ricochet',
            'start_code' => 'ricochet',
            'name' => 'Ricochet',
            'engine' => 'GoldSource',
            'engine_version' => '1',
            'steam_app_id_nix' => 90,
            'steam_app_id_win' => 90,
            'steam_app_set_config' => "90 mod ricochet",
        ]);

        DB::table('games')->insert([
            'code' => 'svencoop',
            'start_code' => 'svencoop',
            'name' => 'Sven Co-op',
            'engine' => 'GoldSource',
            'engine_version' => '1',
            'steam_app_id_nix' => 276060,
            'steam_app_id_win' => 276060,
        ]);

        /*
         *  Other source
         */

        DB::table('games')->insert([
            'code' => 'insurgency',
            'start_code' => 'insurgency',
            'name' => 'Insurgency',
            'engine' => 'Source',
            'engine_version' => '1',
            'steam_app_id_nix' => 237410,
            'steam_app_id_win' => 237410,
        ]);

        DB::table('games')->insert([
            'code' => 'garrysmod',
            'start_code' => 'garrysmod',
            'name' => 'Garry`s Mod',
            'engine' => 'Source',
            'engine_version' => '1',
            'steam_app_id_nix' => 4020,
            'steam_app_id_win' => 4020,
        ]);

        DB::table('games')->insert([
            'code' => 'pvk2',
            'start_code' => 'pvk2',
            'name' => 'Pirates, Vikings, and Knights II',
            'engine' => 'Source',
            'engine_version' => '1',
            'steam_app_id_nix' => 17575,
            'steam_app_id_win' => 17575,
        ]);

        DB::table('games')->insert([
            'code' => 'nmrih',
            'start_code' => 'nmrih',
            'name' => 'No More Room In Hell',
            'engine' => 'Source',
            'engine_version' => '1',
            'steam_app_id_nix' => 317670,
            'steam_app_id_win' => 317670,
        ]);

        DB::table('games')->insert([
            'code' => 'synergy',
            'start_code' => 'synergy',
            'name' => 'Synergy',
            'engine' => 'Source',
            'engine_version' => '1',
            'steam_app_id_nix' => 17525,
            'steam_app_id_win' => 17525,
        ]);

//        DB::table('games')->insert([
//            'code' => 'dota2',
//            'start_code' => 'dota2',
//            'name' => 'Dota 2',
//            'engine' => 'Source',
//            'engine_version' => '1',
//            'steam_app_id_nix' => 570,
//        ]);

        /*
         *  Minecraft
         */

        DB::table('games')->insert([
            'code' => 'minecraft',
            'start_code' => 'minecraft',
            'name' => 'Minecraft',
            'engine' => 'Minecraft',
        ]);

        DB::table('games')->insert([
            'code' => 'pmmp',
            'start_code' => 'pmmp',
            'name' => 'PocketMineMP (Minecraft PE)',
            'engine' => 'Minecraft',
        ]);

        /*
         *  Arma
         */

        DB::table('games')->insert([
            'code' => 'arma2',
            'start_code' => 'arma2',
            'name' => 'Arma 2',
            'engine' => 'RealVirtuality',
            'engine_version' => '3',
            'steam_app_id_win' => 33905,
        ]);

        DB::table('games')->insert([
            'code' => 'arma2oa',
            'start_code' => 'arma2oa',
            'name' => 'Arma 2: Operation Arrowhead',
            'engine' => 'RealVirtuality',
            'engine_version' => '3',
            'steam_app_id_win' => 33935,
        ]);

        DB::table('games')->insert([
            'code' => 'arma3',
            'start_code' => 'arma3',
            'name' => 'Arma 3',
            'engine' => 'RealVirtuality',
            'engine_version' => '4',
            'steam_app_id_nix' => 233780,
            'steam_app_id_win' => 233780,
        ]);

        /*
         *  Call of duty
         */

        DB::table('games')->insert([
            'code' => 'cod3',
            'start_code' => 'cod3',
            'name' => 'Call of Duty 3',
            'engine' => 'Treyarch NGL',
            'steam_app_id_win' => 42750,
        ]);

        DB::table('games')->insert([
            'code' => 'cod4',
            'start_code' => 'cod4',
            'name' => 'Call of Duty 4',
            'engine' => 'IWEngine',
            'engine_version' => '3.0',
        ]);

        /*
         *  GTA
         */

        DB::table('games')->insert([
            'code' => 'samp',
            'start_code' => 'samp',
            'name' => 'SA-MP',
            'engine' => 'RenderWare',
        ]);

        DB::table('games')->insert([
            'code' => 'mta',
            'start_code' => 'mta',
            'name' => 'GTA: Multi Theft Auto',
            'engine' => 'RenderWare',
        ]);

        DB::table('games')->insert([
            'code' => 'fivem',
            'start_code' => 'fivem',
            'name' => 'FiveM',
            'engine' => 'Rage',
        ]);

        DB::table('games')->insert([
            'code' => 'ragemp',
            'start_code' => 'ragemp',
            'name' => 'RageMP',
            'engine' => 'Rage',
            'remote_repository_nix' => 'https://cdn.rage.mp/updater/prerelease/server-files/linux_x64.tar.gz',
            'remote_repository_win' => '',
        ]);

        /*
         *  Just Cause
         */

        DB::table('games')->insert([
            'code' => 'justcause2',
            'start_code' => 'justcause2',
            'name' => 'Just Cause 2',
            'engine' => 'AvalancheEngine',
            'engine_version' => '2.0',
            'steam_app_id_nix' => 261140,
            'steam_app_id_win' => 261140,
        ]);

        DB::table('games')->insert([
            'code' => 'justcause3',
            'start_code' => 'justcause3',
            'name' => 'Just Cause 3',
            'engine' => 'AvalancheEngine',
            'engine_version' => '3.0',
        ]);

        /*
         *  Killing Floor
         */

//        DB::table('games')->insert([
//            'code' => 'killingfloor',
//            'start_code' => 'killingfloor',
//            'name' => 'Killing Floor',
//            'engine' => 'UnrealEngine',
//            'engine_version' => '2.5',
//            'steam_app_id_nix' => 215360,
//            'steam_app_id_win' => 215350,
//        ]);

        DB::table('games')->insert([
            'code' => 'killingfloor2',
            'start_code' => 'killingfloor2',
            'name' => 'Killing Floor 2',
            'engine' => 'UnrealEngine',
            'engine_version' => '3',
            'steam_app_id_nix' => 232130,
            'steam_app_id_win' => 232130,
        ]);

        /*
         *  Other games
         */

        DB::table('games')->insert([
            'code' => 'ark',
            'start_code' => 'ark',
            'name' => 'ARK: Survival Evolved',
            'engine' => 'Unreal Engine',
            'engine_version' => '4',
            'steam_app_id_nix' => 376030,
            'steam_app_id_win' => 376030,
        ]);
        
        DB::table('games')->insert([
            'code' => 'rust',
            'start_code' => 'rust',
            'name' => 'Rust',
            'engine' => 'Unity',
            'steam_app_id_win' => 258550,
        ]);
        
        DB::table('games')->insert([
            'code' => 'hurtworld',
            'start_code' => 'hurtworld',
            'name' => 'HurtWorld',
            'engine' => 'Unity',
            'steam_app_id_nix' => 405100,
            'steam_app_id_win' => 405100,
        ]);

        DB::table('games')->insert([
            'code' => '7d2d',
            'start_code' => '7d2d',
            'name' => '7 Days to Die',
            'engine' => 'Unity',
            'steam_app_id_nix' => 294420,
            'steam_app_id_win' => 294420,
        ]);

        DB::table('games')->insert([
            'code' => 'the-forest',
            'start_code' => 'the-forest',
            'name' => 'The Forest',
            'engine' => 'Unity',
            'steam_app_id_win' => 556450,
        ]);

        DB::table('games')->insert([
            'code' => 'rok',
            'start_code' => 'rok',
            'name' => 'Reign Of Kings',
            'engine' => 'Unity',
            'steam_app_id_win' => 344760,
        ]);

        DB::table('games')->insert([
            'code' => 'dst',
            'start_code' => 'dst',
            'name' => 'Don`t Starve Together',
            'engine' => 'Don`t Starve',
            'engine_version' => '1',
            'steam_app_id_nix' => 343050,
        ]);

        DB::table('games')->insert([
            'code' => 'teeworlds',
            'start_code' => 'teeworlds',
            'name' => 'Teeworlds',
            'engine' => 'Teeworlds',
        ]);

//        DB::table('games')->insert([
//            'code' => 'terraria',
//            'start_code' => 'terraria',
//            'name' => 'Terraria',
//            'engine' => 'Terraria',
//            'steam_app_id_nix' => 105600,
//        ]);

//        DB::table('games')->insert([
//            'code' => 'unturned',
//            'start_code' => 'unturned',
//            'name' => 'Unturned',
//            'engine' => 'Unturned',
//            'steam_app_id_nix' => 1110390,
//        ]);

        /*
         *  Software
         */

//        DB::table('games')->insert([
//            'code' => 'ts3',
//            'start_code' => 'ts3',
//            'name' => 'TeamSpeak',
//            'engine' => 'TeamSpeak',
//        ]);

//        DB::table('games')->insert([
//            'code' => 'mumble',
//            'start_code' => 'mumble',
//            'name' => 'Mumble',
//            'engine' => 'Mumble',
//        ]);
    }
}
