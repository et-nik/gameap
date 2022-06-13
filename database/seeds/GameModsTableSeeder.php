<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class GameModsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $gapRepoBaseUrl = 'http://files.gameap.ru';

        $defaultGoldSourceFastRcon = [
            [
                'info' => 'Status',
                'command' => 'status',
            ],
            [
                'info' => 'Stats',
                'command' => 'stats',
            ],
        ];

        $defaultGoldSourceAmxFastRcon = array_merge(
            $defaultGoldSourceFastRcon, [
                [
                    'info' => 'Last disconnect players',
                    'command' => 'amx_last',
                ],
                [
                    'info' => 'Admins on servers',
                    'command' => 'amx_who',
                ],
            ]
        );

        ###
        ### Half life
        ###

        /* Half-Life */

        DB::table('game_mods')->insert([
            'game_code' => 'valve',
            'name' => 'Default',
            'fast_rcon' => json_encode($defaultGoldSourceFastRcon),
            'vars' => json_encode(self::getDefaultGoldSourceVars()),
            'start_cmd_linux' => self::getDefaultGoldSourceStartCmd('linux', 'valve'),
            'start_cmd_windows' => self::getDefaultGoldSourceStartCmd('windows', 'valve'),
            'passwd_cmd' => 'password {password}',
            'sendmsg_cmd' => 'say "{msg}"',
            'chmap_cmd' => 'changelevel {map}',
            'srestart_cmd' => 'restart',
            'kick_cmd' => 'kick #{id}',
        ]);

        DB::table('game_mods')->insert([
            'game_code' => 'valve',
            'name' => 'Classic (AMX Mod)',
            'fast_rcon' => json_encode($defaultGoldSourceAmxFastRcon),
            'vars' => json_encode(self::getDefaultGoldSourceVars()),
            'remote_repository_linux' => $gapRepoBaseUrl . '/half-life/amxx.tar.xz',
            'remote_repository_windows' => $gapRepoBaseUrl . '/half-life/amxx.tar.xz',
            'start_cmd_linux' => self::getDefaultGoldSourceStartCmd('linux', 'valve'),
            'start_cmd_windows' => self::getDefaultGoldSourceStartCmd('windows', 'valve'),
            'passwd_cmd' => 'password {password}',
            'sendmsg_cmd' => 'amx_say "{msg}"',
            'chmap_cmd' => 'changelevel {map}',
            'srestart_cmd' => 'restart',
            'chname_cmd' => 'amx_nick #{id} {name}',
            'ban_cmd' => 'amx_ban "{name}" {time} "{reason}"',
            'kick_cmd' => 'kick #{id}',
        ]);

        DB::table('game_mods')->insert([
            'game_code' => 'valve',
            'name' => 'Classic (ReHLDS)',
            'fast_rcon' => json_encode($defaultGoldSourceFastRcon),
            'vars' => json_encode(self::getDefaultGoldSourceVars()),
            'remote_repository_linux' => $gapRepoBaseUrl . '/half-life/rehlds-amxx-reunion.tar.xz',
            'remote_repository_windows' => $gapRepoBaseUrl . '/half-life/rehlds-amxx-reunion.tar.xz',
            'start_cmd_linux' => self::getDefaultGoldSourceStartCmd('linux', 'valve'),
            'start_cmd_windows' => self::getDefaultGoldSourceStartCmd('windows', 'valve'),
            'passwd_cmd' => 'password {password}',
            'sendmsg_cmd' => 'say "{msg}"',
            'chmap_cmd' => 'changelevel {map}',
            'srestart_cmd' => 'restart',
            'kick_cmd' => 'kick #{id}',
        ]);

        /* Half-Life: Opposing Force */

        DB::table('game_mods')->insert([
            'game_code' => 'op4',
            'name' => 'Default',
            'fast_rcon' => json_encode($defaultGoldSourceFastRcon),
            'vars' => json_encode(self::getDefaultGoldSourceVars()),
            'start_cmd_linux' => self::getDefaultGoldSourceStartCmd('linux', 'valve'),
            'start_cmd_windows' => self::getDefaultGoldSourceStartCmd('windows', 'valve'),
            'passwd_cmd' => 'password {password}',
            'sendmsg_cmd' => 'say "{msg}"',
            'chmap_cmd' => 'changelevel {map}',
            'srestart_cmd' => 'restart',
            'kick_cmd' => 'kick #{id}',
        ]);

        /* Half Life 2 */

        DB::table('game_mods')->insert([
            'game_code' => 'hl2mp',
            'name' => 'Default',
            'vars' => json_encode(self::getDefaultSourceVars()),
            'start_cmd_linux' => self::getDefaultSourceStartCmd('linux', ''),
            'start_cmd_windows' => self::getDefaultSourceStartCmd('windows', ''),
            'passwd_cmd' => 'password {password}',
            'sendmsg_cmd' => 'say "{msg}"',
            'chmap_cmd' => 'changelevel {map}',
            'srestart_cmd' => 'restart',
            'kick_cmd' => 'kick #{id}',
        ]);

        /* Black Mesa: Deathmatch */

        DB::table('game_mods')->insert([
            'game_code' => 'bms',
            'name' => 'Default',
            'vars' => json_encode(self::getDefaultSourceVars()),
            'start_cmd_linux' => self::getDefaultSourceStartCmd('linux', 'bms'),
            'start_cmd_windows' => self::getDefaultSourceStartCmd('windows', 'bms'),
            'passwd_cmd' => 'password {password}',
            'sendmsg_cmd' => 'say "{msg}"',
            'chmap_cmd' => 'changelevel {map}',
            'srestart_cmd' => 'restart',
            'kick_cmd' => 'kick #{id}',
        ]);

        ###
        ### Counter Strike
        ###

        /* Counter-Strike 1.6 */

        DB::table('game_mods')->insert([
            'game_code' => 'cstrike',
            'name' => 'Default',
            'fast_rcon' => json_encode($defaultGoldSourceFastRcon),
            'vars' => json_encode(self::getDefaultGoldSourceVars('de_dust2')),
            'start_cmd_linux' => self::getDefaultGoldSourceStartCmd('linux', 'cstrike'),
            'start_cmd_windows' => self::getDefaultGoldSourceStartCmd('windows', 'cstrike'),
            'passwd_cmd' => 'password {password}',
            'sendmsg_cmd' => 'say "{msg}"',
            'chmap_cmd' => 'changelevel {map}',
            'srestart_cmd' => 'restart',
            'kick_cmd' => 'kick #{id}',
        ]);

        DB::table('game_mods')->insert([
            'game_code' => 'cstrike',
            'name' => 'Classic (AMX Mod)',
            'fast_rcon' => json_encode($defaultGoldSourceAmxFastRcon),
            'vars' => json_encode(self::getDefaultGoldSourceVars('de_dust2')),
            'remote_repository_linux' => $gapRepoBaseUrl . '/cstrike-1.6/amxx.tar.xz',
            'remote_repository_windows' => $gapRepoBaseUrl . '/cstrike-1.6/amxx.tar.xz',
            'start_cmd_linux' => self::getDefaultGoldSourceStartCmd('linux', 'cstrike'),
            'start_cmd_windows' => self::getDefaultGoldSourceStartCmd('windows', 'cstrike'),
            'passwd_cmd' => 'password {password}',
            'sendmsg_cmd' => 'amx_say "{msg}"',
            'chmap_cmd' => 'changelevel {map}',
            'srestart_cmd' => 'restart',
            'chname_cmd' => 'amx_nick #{id} {name}',
            'ban_cmd' => 'amx_ban "{name}" {time} "{reason}"',
            'kick_cmd' => 'kick #{id}',
        ]);

        DB::table('game_mods')->insert([
            'game_code' => 'cstrike',
            'name' => 'Classic (ReHLDS)',
            'fast_rcon' => json_encode($defaultGoldSourceFastRcon),
            'vars' => json_encode(self::getDefaultGoldSourceVars('de_dust2')),
            'remote_repository_linux' => $gapRepoBaseUrl . '/cstrike-1.6/rehlds-amxx-reunion.tar.xz',
            'remote_repository_windows' => $gapRepoBaseUrl . '/cstrike-1.6/rehlds-amxx-reunion.tar.xz',
            'start_cmd_linux' => self::getDefaultGoldSourceStartCmd('linux', 'cstrike'),
            'start_cmd_windows' => self::getDefaultGoldSourceStartCmd('windows', 'cstrike'),
            'passwd_cmd' => 'password {password}',
            'sendmsg_cmd' => 'say "{msg}"',
            'chmap_cmd' => 'changelevel {map}',
            'srestart_cmd' => 'restart',
            'kick_cmd' => 'kick #{id}',
        ]);

        /* Counter-Strike Condition Zero */

        DB::table('game_mods')->insert([
            'game_code' => 'czero',
            'name' => 'Default',
            'fast_rcon' => json_encode($defaultGoldSourceFastRcon),
            'vars' => json_encode(self::getDefaultGoldSourceVars('de_dust')),
            'start_cmd_linux' => self::getDefaultGoldSourceStartCmd('linux', 'czero'),
            'start_cmd_windows' => self::getDefaultGoldSourceStartCmd('windows', 'czero'),
            'passwd_cmd' => 'password {password}',
            'sendmsg_cmd' => 'say "{msg}"',
            'chmap_cmd' => 'changelevel {map}',
            'srestart_cmd' => 'restart',
            'kick_cmd' => 'kick #{id}',
        ]);

        /* Counter-Strike Source v34*/

        DB::table('game_mods')->insert([
            'game_code' => 'cssv34',
            'name' => 'Default',
            'vars' => json_encode(self::getDefaultSourceVars('de_dust2')),
            'start_cmd_linux' => self::getDefaultSourceStartCmd('linux', 'cstrike'),
            'start_cmd_windows' => self::getDefaultSourceStartCmd('windows', 'cstrike'),
            'passwd_cmd' => 'password {password}',
            'sendmsg_cmd' => 'say "{msg}"',
            'chmap_cmd' => 'changelevel {map}',
            'srestart_cmd' => 'restart',
            'kick_cmd' => 'kick #{id}',
        ]);

        /* Counter-Strike Source */

        DB::table('game_mods')->insert([
            'game_code' => 'cssource',
            'name' => 'Default',
            'vars' => json_encode(self::getDefaultSourceVars('de_dust2')),
            'start_cmd_linux' => self::getDefaultSourceStartCmd('linux', 'cstrike'),
            'start_cmd_windows' => self::getDefaultSourceStartCmd('windows', 'cstrike'),
            'passwd_cmd' => 'password {password}',
            'sendmsg_cmd' => 'say "{msg}"',
            'chmap_cmd' => 'changelevel {map}',
            'srestart_cmd' => 'restart',
            'kick_cmd' => 'kick #{id}',
        ]);

        /* Counter-Strike Global Offensive */

        DB::table('game_mods')->insert([
            'game_code' => 'csgo',
            'name' => 'Default',
            'vars' => json_encode(array_merge(self::getDefaultSourceVars('de_dust2'), [
                [
                    'var' => 'mapgroup',
                    'default' => 'mg_active',
                    'info' => 'Map group',
                ],
                [
                    'var' => 'steamaccount',
                    'default' => '',
                    'info' => 'Steam account token',
                ],
            ])),
            'start_cmd_linux' => self::getDefaultSourceStartCmd('linux', 'csgo') . ' +sv_setsteamaccount {steamaccount} +mapgroup {mapgroup} +game_type 0 +game_mode 0',
            'start_cmd_windows' => self::getDefaultSourceStartCmd('windows', 'csgo') . ' +sv_setsteamaccount {steamaccount} +mapgroup {mapgroup} +game_type 0 +game_mode 0',
            'passwd_cmd' => 'password {password}',
            'sendmsg_cmd' => 'say "{msg}"',
            'chmap_cmd' => 'changelevel {map}',
            'srestart_cmd' => 'restart',
            'kick_cmd' => 'kick #{id}',
        ]);

        DB::table('game_mods')->insert([
            'game_code' => 'csgo',
            'name' => 'Competitive',
            'vars' => json_encode(array_merge(self::getDefaultSourceVars('de_dust2'), [
                [
                    'var' => 'mapgroup',
                    'default' => 'mg_active',
                    'info' => 'Map group',
                ],
                [
                    'var' => 'steamaccount',
                    'default' => '',
                    'info' => 'Steam account token',
                ],
            ])),
            'start_cmd_linux' => self::getDefaultSourceStartCmd('linux', 'csgo') . ' +sv_setsteamaccount {steamaccount} +mapgroup {mapgroup} +game_type 0 +game_mode 1',
            'start_cmd_windows' => self::getDefaultSourceStartCmd('windows', 'csgo') . ' +sv_setsteamaccount {steamaccount} +mapgroup {mapgroup} +game_type 0 +game_mode 1',
            'passwd_cmd' => 'password {password}',
            'sendmsg_cmd' => 'say "{msg}"',
            'chmap_cmd' => 'changelevel {map}',
            'srestart_cmd' => 'restart',
            'kick_cmd' => 'kick #{id}',
        ]);

        DB::table('game_mods')->insert([
            'game_code' => 'csgo',
            'name' => 'Gungame',
            'vars' => json_encode(array_merge(self::getDefaultSourceVars('de_dust2'), [
                [
                    'var' => 'mapgroup',
                    'default' => 'mg_active',
                    'info' => 'Map group',
                ],
                [
                    'var' => 'steamaccount',
                    'default' => '',
                    'info' => 'Steam account token',
                ],
            ])),
            'start_cmd_linux' => self::getDefaultSourceStartCmd('linux', 'csgo') . ' +sv_setsteamaccount {steamaccount} +mapgroup {mapgroup} +game_type 1 +game_mode 0',
            'start_cmd_windows' => self::getDefaultSourceStartCmd('windows', 'csgo') . ' +sv_setsteamaccount {steamaccount} +mapgroup {mapgroup} +game_type 1 +game_mode 0',
            'passwd_cmd' => 'password {password}',
            'sendmsg_cmd' => 'say "{msg}"',
            'chmap_cmd' => 'changelevel {map}',
            'srestart_cmd' => 'restart',
            'kick_cmd' => 'kick #{id}',
        ]);

        DB::table('game_mods')->insert([
            'game_code' => 'csgo',
            'name' => 'Demolition',
            'vars' => json_encode(array_merge(self::getDefaultSourceVars('de_dust2'), [
                [
                    'var' => 'mapgroup',
                    'default' => 'mg_active',
                    'info' => 'Map group',
                ],
                [
                    'var' => 'steamaccount',
                    'default' => '',
                    'info' => 'Steam account token',
                ],
            ])),
            'start_cmd_linux' => self::getDefaultSourceStartCmd('linux', 'csgo') . ' +sv_setsteamaccount {steamaccount} +mapgroup {mapgroup} +game_type 1 +game_mode 1',
            'start_cmd_windows' => self::getDefaultSourceStartCmd('windows', 'csgo') . ' +sv_setsteamaccount {steamaccount} +mapgroup {mapgroup} +game_type 1 +game_mode 1',
            'passwd_cmd' => 'password {password}',
            'sendmsg_cmd' => 'say "{msg}"',
            'chmap_cmd' => 'changelevel {map}',
            'srestart_cmd' => 'restart',
            'kick_cmd' => 'kick #{id}',
        ]);

        DB::table('game_mods')->insert([
            'game_code' => 'csgo',
            'name' => 'Deathmatch',
            'vars' => json_encode(array_merge(self::getDefaultSourceVars('de_dust2'), [
                [
                    'var' => 'mapgroup',
                    'default' => 'mg_active',
                    'info' => 'Map group',
                ],
                [
                    'var' => 'steamaccount',
                    'default' => '',
                    'info' => 'Steam account token',
                ],
            ])),
            'start_cmd_linux' => self::getDefaultSourceStartCmd('linux', 'csgo') . ' +sv_setsteamaccount {steamaccount} +mapgroup {mapgroup} +game_type 1 +game_mode 2',
            'start_cmd_windows' => self::getDefaultSourceStartCmd('windows', 'csgo') . ' +sv_setsteamaccount {steamaccount} +mapgroup {mapgroup} +game_type 1 +game_mode 2',
            'passwd_cmd' => 'password {password}',
            'sendmsg_cmd' => 'say "{msg}"',
            'chmap_cmd' => 'changelevel {map}',
            'srestart_cmd' => 'restart',
            'kick_cmd' => 'kick #{id}',
        ]);

        ###
        ### Team Fortress
        ###

        /* Team Fortress Classic */

        DB::table('game_mods')->insert([
            'game_code' => 'tfc',
            'name' => 'Default',
            'vars' => json_encode(self::getDefaultSourceVars('2fort')),
            'start_cmd_linux' => self::getDefaultSourceStartCmd('linux', 'tfc'),
            'start_cmd_windows' => self::getDefaultSourceStartCmd('windows', 'tfc'),
            'passwd_cmd' => 'password {password}',
            'sendmsg_cmd' => 'say "{msg}"',
            'chmap_cmd' => 'changelevel {map}',
            'srestart_cmd' => 'restart',
            'kick_cmd' => 'kick #{id}',
        ]);

        /* Team Fortress 2 */

        DB::table('game_mods')->insert([
            'game_code' => 'tf2',
            'name' => 'Default',
            'vars' => json_encode(self::getDefaultSourceVars('ctf_2fort')),
            'start_cmd_linux' => self::getDefaultSourceStartCmd('linux', 'tf'),
            'start_cmd_windows' => self::getDefaultSourceStartCmd('windows', 'tf'),
            'passwd_cmd' => 'password {password}',
            'sendmsg_cmd' => 'say "{msg}"',
            'chmap_cmd' => 'changelevel {map}',
            'srestart_cmd' => 'restart',
            'kick_cmd' => 'kick #{id}',
        ]);

        ###
        ### Day of Defeat
        ###

        /* Day of Defeat */

        DB::table('game_mods')->insert([
            'game_code' => 'dod',
            'name' => 'Default',
            'vars' => json_encode(self::getDefaultSourceVars('dod_anzio')),
            'start_cmd_linux' => self::getDefaultSourceStartCmd('linux', 'dod'),
            'start_cmd_windows' => self::getDefaultSourceStartCmd('windows', 'dod'),
            'passwd_cmd' => 'password {password}',
            'sendmsg_cmd' => 'say "{msg}"',
            'chmap_cmd' => 'changelevel {map}',
            'srestart_cmd' => 'restart',
            'kick_cmd' => 'kick #{id}',
        ]);

        /* Day of Defeat Source */

        DB::table('game_mods')->insert([
            'game_code' => 'dods',
            'name' => 'Default',
            'vars' => json_encode(self::getDefaultSourceVars('dod_anzio')),
            'start_cmd_linux' => self::getDefaultSourceStartCmd('linux', 'dods'),
            'start_cmd_windows' => self::getDefaultSourceStartCmd('windows', 'dods'),
            'passwd_cmd' => 'password {password}',
            'sendmsg_cmd' => 'say "{msg}"',
            'chmap_cmd' => 'changelevel {map}',
            'srestart_cmd' => 'restart',
            'kick_cmd' => 'kick #{id}',
        ]);

        ###
        ### Left 4 Dead
        ###

        /* Left 4 Dead */

        DB::table('game_mods')->insert([
            'game_code' => 'l4d',
            'name' => 'Default',
            'fast_rcon' => json_encode($defaultGoldSourceFastRcon),
            'vars' => json_encode(self::getDefaultGoldSourceVars('l4d_farm04_barn')),
            'start_cmd_linux' => self::getDefaultGoldSourceStartCmd('linux', 'left4dead'),
            'start_cmd_windows' => self::getDefaultGoldSourceStartCmd('windows', 'left4dead'),
            'passwd_cmd' => 'password {password}',
            'sendmsg_cmd' => 'say "{msg}"',
            'chmap_cmd' => 'changelevel {map}',
            'srestart_cmd' => 'restart',
            'kick_cmd' => 'kick #{id}',
        ]);

        /* Left 4 Dead 2 */

        DB::table('game_mods')->insert([
            'game_code' => 'l4d2',
            'name' => 'Default',
            'fast_rcon' => json_encode($defaultGoldSourceFastRcon),
            'vars' => json_encode(self::getDefaultSourceVars('c2m1_highway')),
            'start_cmd_linux' => self::getDefaultSourceStartCmd('linux', 'left4dead2'),
            'start_cmd_windows' => self::getDefaultSourceStartCmd('windows', 'left4dead2'),
            'passwd_cmd' => 'password {password}',
            'sendmsg_cmd' => 'say "{msg}"',
            'chmap_cmd' => 'changelevel {map}',
            'srestart_cmd' => 'restart',
            'kick_cmd' => 'kick #{id}',
        ]);

        ###
        ### Other GoldSource
        ###

        /* Deathmatch Classic */

        DB::table('game_mods')->insert([
            'game_code' => 'dmc',
            'name' => 'Default',
            'vars' => json_encode(self::getDefaultSourceVars('')),
            'start_cmd_linux' => self::getDefaultSourceStartCmd('linux', ''),
            'start_cmd_windows' => self::getDefaultSourceStartCmd('windows', ''),
            'passwd_cmd' => 'password {password}',
            'sendmsg_cmd' => 'say "{msg}"',
            'chmap_cmd' => 'changelevel {map}',
            'srestart_cmd' => 'restart',
            'kick_cmd' => 'kick #{id}',
        ]);

        /* Ricochet */

        DB::table('game_mods')->insert([
            'game_code' => 'ricochet',
            'name' => 'Default',
            'vars' => json_encode(self::getDefaultSourceVars('')),
            'start_cmd_linux' => self::getDefaultSourceStartCmd('linux', ''),
            'start_cmd_windows' => self::getDefaultSourceStartCmd('windows', ''),
            'passwd_cmd' => 'password {password}',
            'sendmsg_cmd' => 'say "{msg}"',
            'chmap_cmd' => 'changelevel {map}',
            'srestart_cmd' => 'restart',
            'kick_cmd' => 'kick #{id}',
        ]);

        /* Sven Co-op */

        DB::table('game_mods')->insert([
            'game_code' => 'svencoop',
            'name' => 'Default',
            'vars' => json_encode(self::getDefaultGoldSourceVars('stadium4')),
            'start_cmd_linux' => self::getDefaultGoldSourceStartCmd('linux', '', './svends_run'),
            'start_cmd_windows' => self::getDefaultGoldSourceStartCmd('windows', '', 'svends.exe'),
            'passwd_cmd' => 'password {password}',
            'sendmsg_cmd' => 'say "{msg}"',
            'chmap_cmd' => 'changelevel {map}',
            'srestart_cmd' => 'restart',
            'kick_cmd' => 'kick #{id}',
        ]);

        ###
        ### Other Source
        ###

        /* Insurgency */

        DB::table('game_mods')->insert([
            'game_code' => 'insurgency',
            'name' => 'Default',
            'vars' => json_encode(self::getDefaultSourceVars('ministry')),
            'start_cmd_linux' => self::getDefaultSourceStartCmd('linux'),
            'start_cmd_windows' => self::getDefaultSourceStartCmd('windows'),
            'passwd_cmd' => 'password {password}',
            'sendmsg_cmd' => 'say "{msg}"',
            'chmap_cmd' => 'changelevel {map}',
            'srestart_cmd' => 'restart',
            'kick_cmd' => 'kick #{id}',
        ]);

        /* Garry's Mod */

        DB::table('game_mods')->insert([
            'game_code' => 'garrysmod',
            'name' => 'Default',
            'vars' => json_encode(self::getDefaultSourceVars('gm_construct')),
            'start_cmd_linux' => self::getDefaultSourceStartCmd('linux', 'garrysmod'),
            'start_cmd_windows' => self::getDefaultSourceStartCmd('windows', 'garrysmod'),
            'passwd_cmd' => 'password {password}',
            'sendmsg_cmd' => 'say "{msg}"',
            'chmap_cmd' => 'changelevel {map}',
            'srestart_cmd' => 'restart',
            'kick_cmd' => 'kick #{id}',
        ]);

        /* No More Room In Hell */

        DB::table('game_mods')->insert([
            'game_code' => 'nmrih',
            'name' => 'Default',
            'vars' => json_encode(self::getDefaultSourceVars('')),
            'start_cmd_linux' => self::getDefaultSourceStartCmd('linux', ''),
            'start_cmd_windows' => self::getDefaultSourceStartCmd('windows', ''),
            'passwd_cmd' => 'password {password}',
            'sendmsg_cmd' => 'say "{msg}"',
            'chmap_cmd' => 'changelevel {map}',
            'srestart_cmd' => 'restart',
            'kick_cmd' => 'kick #{id}',
        ]);

        /* Pirates, Vikings, and Knights II */

        DB::table('game_mods')->insert([
            'game_code' => 'pvk2',
            'name' => 'Default',
            'vars' => json_encode(self::getDefaultSourceVars('')),
            'start_cmd_linux' => self::getDefaultSourceStartCmd('linux', ''),
            'start_cmd_windows' => self::getDefaultSourceStartCmd('windows', ''),
            'passwd_cmd' => 'password {password}',
            'sendmsg_cmd' => 'say "{msg}"',
            'chmap_cmd' => 'changelevel {map}',
            'srestart_cmd' => 'restart',
            'kick_cmd' => 'kick #{id}',
        ]);

        /* Synergy */

        DB::table('game_mods')->insert([
            'game_code' => 'synergy',
            'name' => 'Default',
            'vars' => json_encode(self::getDefaultSourceVars('d1_trainstation_01')),
            'start_cmd_linux' => self::getDefaultSourceStartCmd('linux', 'synergy'),
            'start_cmd_windows' => self::getDefaultSourceStartCmd('windows', 'synergy'),
            'passwd_cmd' => 'password {password}',
            'sendmsg_cmd' => 'say "{msg}"',
            'chmap_cmd' => 'changelevel {map}',
            'srestart_cmd' => 'restart',
            'kick_cmd' => 'kick #{id}',
        ]);

        ###
        ### Minecraft
        ###

        /* Minecraft */

        DB::table('game_mods')->insert([
            'game_code' => 'minecraft',
            'name' => 'Default',
            'vars' => json_encode([
                [
                    'var' => 'world',
                    'default' => 'world',
                    'info' => 'World file',
                ],
                [
                    'var' => 'java_xms',
                    'default' => '1G',
                    'info' => 'Java start RAM amount',
                    'admin_var' => true,
                ],
                [
                    'var' => 'java_xmx',
                    'default' => '2G',
                    'info' => 'Java max RAM amount',
                    'admin_var' => true,
                ],
            ]),
            'remote_repository_linux' => 'https://launcher.mojang.com/v1/objects/c8f83c5655308435b3dcf03c06d9fe8740a77469/server.jar',
            'remote_repository_windows' => 'https://launcher.mojang.com/v1/objects/c8f83c5655308435b3dcf03c06d9fe8740a77469/server.jar',
            'start_cmd_linux' => 'java -Xms{java_xms} -Xmx{java_xms} -jar server.jar --port {port} --world {world} --nogui',
            'start_cmd_windows' => 'java -Xms{java_xms} -Xmx{java_xms} -jar server.jar --port {port} --world {world} --nogui',
        ]);

        DB::table('game_mods')->insert([
            'game_code' => 'minecraft',
            'name' => 'Multicore',
            'vars' => json_encode([
                [
                    'var' => 'version',
                    'default' => '1.14.3',
                    'info' => 'Minecraft version',
                ],
                [
                    'var' => 'core_mod',
                    'default' => 'vanilla',
                    'info' => 'Core',
                ],
                [
                    'var' => 'core_mod_version',
                    'default' => null,
                    'info' => 'Core mod version',
                ],
            ]),
            'remote_repository_linux' => $gapRepoBaseUrl . '/minecraft/minecraft-runner.tar.gz',
            'remote_repository_windows' => $gapRepoBaseUrl . '/minecraft/minecraft-runner.tar.gz',
            'start_cmd_linux' => './mcrun.sh run --version={version} --core-mod={core_mod} --core-mod-version={core_mod_version} --ip={ip} --port={port} --query-port={query_port} --rcon-port={rcon_port} --rcon-password={rcon_password}',
        ]);

        /* PMMP (MinecraftPE) */

        DB::table('game_mods')->insert([
            'game_code' => 'pmmp',
            'name' => 'Default',
            'remote_repository_linux' => 'https://github.com/pmmp/PocketMine-MP/releases/download/4.2.7/PocketMine-MP.phar',
            'remote_repository_windows' => 'https://github.com/pmmp/PocketMine-MP/releases/download/4.2.7/PocketMine-MP.phar',
            'start_cmd_linux' => './bin/php7/bin/php ./PocketMine-MP.phar',
            'start_cmd_windows' => '',
            'passwd_cmd' => 'password {password}',
            'sendmsg_cmd' => 'say {msg}',
            'srestart_cmd' => 'reload',
            'ban_cmd' => 'ban {name} {reason}',
            'kick_cmd' => 'kick {name}',
        ]);

        ###
        ### GTA
        ###

        /* SAMP */
        // ToDo: pre run script - move files from folder samp03 to server root

        DB::table('game_mods')->insert([
            'game_code' => 'samp',
            'name' => 'Default (Freeroam)',
            'remote_repository_linux' => 'http://files.sa-mp.com/samp037svr_R2-1.tar.gz',
            'remote_repository_windows' => 'http://files.sa-mp.com/samp037_svr_R2-1-1_win32.zip',
            'start_cmd_linux' => './samp03svr',
            'start_cmd_windows' => 'samp-server.exe',
        ]);

        /* Multi Theft Auto (MTA) */

        DB::table('game_mods')->insert([
            'game_code' => 'mta',
            'name' => 'DeathMatch',
            'vars' => json_encode([
                [
                    'var' => 'maxplayers',
                    'default' => 32,
                    'info' => 'Maximum players on server',
                ]
            ]),
            'remote_repository_linux' => $gapRepoBaseUrl . '/mta/default-deathmatch.tar.xz',
            'remote_repository_windows' => $gapRepoBaseUrl . '/mta/default-deathmatch.tar.xz',
            'start_cmd_linux' => './mta-server64 -t -n --ip {ip} --port {port} --maxplayers {maxplayers}',
            'start_cmd_windows' => '',
        ]);

        /* FiveM */

        DB::table('game_mods')->insert([
            'game_code' => 'fivem',
            'name' => 'Default',
            'vars' => json_encode([
                [
                    'var' => 'hostname',
                    'default' => 'GameAP FiveM Server',
                    'info' => 'Server Hostname',
                ],
                [
                    'var' => 'license_key',
                    'default' => 'changeme',
                    'info' => 'License key from https://keymaster.fivem.net',
                    'admin_var' => true,
                ],
            ]),
            'remote_repository_linux' => $gapRepoBaseUrl . '/fivem/fivem.tar.xz',
            'remote_repository_windows' => $gapRepoBaseUrl . '/fivem/fivem.tar.xz',
            'start_cmd_linux' => './fivem_run.sh --ip={ip} --port={port} --hostname="{hostname}" --rcon-password="{rcon_password}" --license-key="{license_key}"',
            'start_cmd_windows' => 'run.cmd +exec server.cfg',
            'sendmsg_cmd' => 'say {msg}',
            'kick_cmd' => 'clientkick {id}',
        ]);

        /* RageMP */

        DB::table('game_mods')->insert([
            'game_code' => 'ragemp',
            'name' => 'Default',
            'remote_repository_linux' => 'https://cdn.rage.mp/updater/prerelease/server-files/linux_x64.tar.gz',
            'remote_repository_windows' => '',
            'start_cmd_linux' => './ragemp-server',
            'start_cmd_windows' => '',
        ]);

        ###
        ### Just cause
        ###

        /* Just cause 2 */

        DB::table('game_mods')->insert([
            'game_code' => 'justcause2',
            'name' => 'Default',
            'start_cmd_linux' => './Jcmp-Server',
            'start_cmd_windows' => '',
        ]);

        /* Just cause 3 */

        DB::table('game_mods')->insert([
            'game_code' => 'justcause3',
            'name' => 'Default',
            'start_cmd_linux' => './Server',
            'start_cmd_windows' => '',
        ]);

        ###
        ### Arma
        ###

        /* Arma 2 */
        DB::table('game_mods')->insert([
            'game_code' => 'arma2',
            'name' => 'Default',
            'vars' => json_encode([
                [
                    'var' => 'server_name',
                    'default' => 'Arma 2 server',
                    'info' => 'Server name',
                ],
                [
                    'var' => 'config_file',
                    'default' => 'server.cfg',
                    'info' => 'Config file name',
                ],
            ]),
            'start_cmd_linux' => './arma2server -name={server_name} -config={config_file}',
            'start_cmd_windows' => '',
        ]);

        /* Arma 2 OA */
        DB::table('game_mods')->insert([
            'game_code' => 'arma2oa',
            'name' => 'Default',
            'vars' => json_encode([
                [
                    'var' => 'server_name',
                    'default' => 'Arma 2 server',
                    'info' => 'Server name',
                ],
                [
                    'var' => 'config_file',
                    'default' => 'server.cfg',
                    'info' => 'Config file name',
                ],
            ]),
            'start_cmd_linux' => './arma2server -name={server_name} -config={config_file}',
            'start_cmd_windows' => '',
        ]);

        /* Arma 3 */
        DB::table('game_mods')->insert([
            'game_code' => 'arma3',
            'name' => 'Default',
            'vars' => json_encode([
                [
                    'var' => 'server_name',
                    'default' => 'Arma 2 server',
                    'info' => 'Server name',
                ],
                [
                    'var' => 'config_file',
                    'default' => 'server.cfg',
                    'info' => 'Config file name',
                ],
            ]),
            'start_cmd_linux' => './arma3server -name={server_name} -config={config_file}',
            'start_cmd_windows' => '',
        ]);

        ###
        ### Killing floor
        ###

        /* Killing floor */

//        DB::table('game_mods')->insert([
//            'game_code' => 'killingfloor',
//            'name' => 'Default',
//            'vars' => json_encode([
//                [
//                    'var' => 'maxplayers',
//                    'default' => '6',
//                    'info' => 'Maximum players on server',
//                ],
//                [
//                    'var' => 'default_map',
//                    'default' => 'KF-bioticslab',
//                    'info' => 'Default Map',
//                ],
//                [
//                    'var' => 'is_vac',
//                    'default' => 'true',
//                    'info' => 'Is VAC enabled?',
//                ],
//            ]),
//            'start_cmd_linux' => './ucc-bin server {default_map}.rom?game=KFmod.KFGameType?VACSecured={is_vac}?MaxPlayers={maxplayers} -nohomedir',
//            'start_cmd_windows' => 'ucc server {default_map}.rom?game=KFmod.KFGameType?VACSecured={is_vac}?MaxPlayers={maxplayers}',
//        ]);

        /* Killing floor 2 */

        DB::table('game_mods')->insert([
            'game_code' => 'killingfloor2',
            'name' => 'Default',
            'vars' => json_encode([
                'var' => 'default_map',
                'default' => 'kf-bioticslab',
                'info' => 'Default Map',
            ]),
            'start_cmd_linux' => './Binaries/Win64/KFGameSteamServer.bin.x86_64 {default_map}',
            'start_cmd_windows' => 'Binaries\win64\kfserver {default_map}',
        ]);

        ###
        ### Other games
        ###

        /* ARK: Survival Evolved' */

        DB::table('game_mods')->insert([
            'game_code' => 'ark',
            'name' => 'Default',
            'vars' => json_encode([
                [
                    'var' => 'server_password',
                    'default' => '',
                    'info' => 'Server password',
                ],
                [
                    'var' => 'session_name',
                    'default' => 'ARK server',
                    'info' => 'Session name',
                ],
            ]),
            'start_cmd_linux' => './ShooterGameServer TheIsland?listen?SessionName={session_name}?Port={port}?QueryPort={query_port}?MaxPlayers={maxplayers}?ServerPassword={server_password}?ServerAdminPassword={rcon_password} -server -log',
            'start_cmd_windows' => 'ShooterGameServer.exe TheIsland?listen?SessionName={session_name}?Port={port}?QueryPort={query_port}?MaxPlayers={maxplayers}?ServerPassword={server_password}?ServerAdminPassword={rcon_password} exit',
        ]);

        /* HurtWorld */

        DB::table('game_mods')->insert([
            'game_code' => 'hurtworld',
            'name' => 'Default',
            'vars' => json_encode([
                [
                    'var' => 'server_name',
                    'default' => 'HurtWorld server',
                    'info' => 'Server name',
                ],
                [
                    'var' => 'admin_uid',
                    'default' => '',
                    'info' => 'Admin UID',
                ],
                [
                    'var' => 'log_file',
                    'default' => 'gamelog.txt',
                    'info' => 'Log file name',
                ],
            ]),
            'start_cmd_linux' => '',
            'start_cmd_windows' => 'Hurtworld.exe -batchmode -nographics -exec "host {port};queryport {query_port};servername {server_name};addadmin admin_uid" -logfile "{log_file}"',
        ]);

        /* Rust */

        DB::table('game_mods')->insert([
            'game_code' => 'rust',
            'name' => 'Vanilla',
        ]);

        DB::table('game_mods')->insert([
            'game_code' => 'rust',
            'name' => 'Oxide',
        ]);

        /* 7 Reign Of Kings */

        DB::table('game_mods')->insert([
            'game_code' => 'rok',
            'name' => 'Default',
            'start_cmd_linux' => '',
            'start_cmd_windows' => '',
        ]);

        /* 7 Day to Die */

        DB::table('game_mods')->insert([
            'game_code' => '7d2d',
            'name' => 'Default',
            'start_cmd_linux' => './startserver.sh -configfile=serverconfig.xml',
            'start_cmd_windows' => 'startdedicated.bat',
        ]);

        /* Don`t Starve Together */

        DB::table('game_mods')->insert([
            'game_code' => 'dst',
            'name' => 'Default',
            'start_cmd_linux' => './dontstarve_dedicated_server_nullrenderer',
            'start_cmd_windows' => '',
        ]);

        /* The Forest */
        // ToDo: add all launch params https://steamcommunity.com/sharedfiles/filedetails/?id=907906289

        DB::table('game_mods')->insert([
            'game_code' => 'the-forest',
            'name' => 'Default',
            'vars' => json_encode([
                [
                    'var' => 'name',
                    'default' => 'The forest dedicated server',
                    'info' => 'Server name',
                ],
                [
                    'var' => 'password',
                    'default' => '',
                    'info' => 'Server password',
                ],
                [
                    'var' => 'password_admin',
                    'default' => '',
                    'info' => 'Server admin password',
                ],
                [
                    'var' => 'serversteamaccount',
                    'default' => '',
                    'info' => 'Server steam account',
                ],
                [
                    'var' => 'enableVAC',
                    'default' => 'on',
                    'info' => 'Enable VAC?',
                ],
                [
                    'var' => 'serverautosaveinterval',
                    'default' => '15',
                    'info' => 'Autosave interval',
                ],
                [
                    'var' => 'difficulty',
                    'default' => 'Normal',
                    'info' => 'Difficulty',
                ],
                [
                    'var' => 'slot',
                    'default' => '1',
                    'info' => 'slot',
                ],
                [
                    'var' => 'maxplayers',
                    'default' => '8',
                    'info' => 'Max players',
                    'admin_var' => true,
                ],
                [
                    'var' => 'steamport',
                    'default' => '8766',
                    'info' => 'Server steamport',
                    'admin_var' => true,
                ],
            ]),
            'start_cmd_windows' => 'TheForestDedicatedServer.exe -serverip {ip} -servergameport {port} -serverqueryport {query_port} -serversteamport {steamport} -serverplayers {maxplayers} -servername "{servername}" -serverpassword {password} -serverpassword_admin {password_admin} -enableVAC {enableVAC} -serverautosaveinterval {serverautosaveinterval} -difficulty {difficulty} -slot {slot} ',
        ]);

        /* Teeworlds */
        // ToDo: add commands
        // ToDo: add pre run script for generating server.cfg https://www.teeworlds.com/?page=docs&wiki=server_setup

        DB::table('game_mods')->insert([
            'game_code' => 'teeworlds',
            'name' => 'Default',
            'start_cmd_linux' => './teeworlds-0.7.5-linux_x86_64/teeworlds_srv -f server.cfg',
            'start_cmd_windows' => 'teeworlds-0.7.5-win64\teeworlds_srv.exe -f server.cfg',
            'remote_repository_linux' => 'https://github.com/teeworlds/teeworlds/releases/download/0.7.5/teeworlds-0.7.5-linux_x86_64.tar.gz',
            'remote_repository_windows' => 'https://github.com/teeworlds/teeworlds/releases/download/0.7.5/teeworlds-0.7.5-win64.zip',
        ]);

        DB::table('game_mods')->insert([
            'game_code' => 'teeworlds',
            'name' => 'DDrace',
            'start_cmd_linux' => './DDNet-16.0.3-linux_x86_64/DDNet-Server -f server.cfg',
            'start_cmd_windows' => 'DDNet-16.0.3-win64\DDNet-Server.exe -f server.cfg',
            'remote_repository_linux' => 'https://ddnet.tw/downloads/DDNet-16.0.3-linux_x86_64.tar.xz',
            'remote_repository_windows' => 'https://ddnet.tw/downloads/DDNet-16.0.3-win64.zip',
        ]);

        ###
        ### Software
        ###

        /* TeamSpeak 3 */

//        DB::table('game_mods')->insert([
//            'game_code' => 'ts3',
//            'name' => 'Linux',
//            'vars' => json_encode([
//                [
//                    'var' => 'filetransfer_port',
//                    'default' => '30033',
//                    'info' => 'Filetransfer port',
//                    'admin_var' => true,
//                ],
//            ]),
//            'start_cmd_linux' => './teamspeak3-server_linux_amd64/ts3server_minimal_runscript.sh voice_ip={ip} default_voice_port={port} query_ip={ip} query_port={query_port} filetransfer_ip={ip} filetransfer_port={filetransfer_port} license_accepted=1',
//            'start_cmd_windows' => 'teamspeak3-server_win64\ts3server.exe',
//            'remote_repository_linux' => 'https://files.teamspeak-services.com/releases/server/3.13.6/teamspeak3-server_linux_amd64-3.13.6.tar.bz2',
//            'remote_repository_windows' => 'https://files.teamspeak-services.com/releases/server/3.13.6/teamspeak3-server_win64-3.13.6.zip',
//        ]);

    }

    /**
     * @param string $defaultMap
     * @return array[]
     */
    private static function getDefaultGoldSourceVars($defaultMap = 'crossfire')
    {
        return [
            [
                'var' => 'default_map',
                'default' => $defaultMap,
                'info' => 'Default Map',
            ],
            [
                'var' => 'maxplayers',
                'default' => 32,
                'info' => 'Maximum players on server',
                'admin_var' => true,
            ],
            [
                'var' => 'fps',
                'default' => 500,
                'info' => 'Server FPS (tickrate)',
                'admin_var' => true,
            ],
        ];
    }

    /**
     * @param string $os
     * @param string $game
     * @param string $file
     * @return string
     */
    private static function getDefaultGoldSourceStartCmd($os, $game = '', $file = '')
    {
        $cmd = '';
        if(!empty($game)){
            $game = ' -game ' . $game;
        }
        switch ($os) {
            case 'linux':
                if(empty($file)){
                    $file = './hlds_run';
                }
                $cmd = $file . ' -console' . $game . ' +ip {ip} +port {port} +map {default_map} +maxplayers {maxplayers} +sys_ticrate {fps} +rcon_password {rcon_password}';
                break;
            case 'windows':
                if(empty($file)){
                    $file = 'hlds.exe';
                }
                $cmd = $file . ' -console' . $game . ' +ip {ip} +port {port} +map {default_map} +maxplayers {maxplayers} +sys_ticrate {fps} +rcon_password {rcon_password}';
                break;
        }
        return $cmd;
    }

    /**
     * @param string $defaultMap
     * @return array[]
     */
    private static function getDefaultSourceVars($defaultMap = 'crossfire')
    {
        return [
            [
                'var' => 'default_map',
                'default' => $defaultMap,
                'info' => 'Default Map',
            ],
            [
                'var' => 'maxplayers',
                'default' => 32,
                'info' => 'Maximum players on server',
                'admin_var' => true,
            ],
            [
                'var' => 'tickrate',
                'default' => 64,
                'info' => 'Server tickrate',
                'admin_var' => true,
            ]
        ];
    }

    /**
     * @param string $os
     * @param string $game
     * @param string $file
     * @return string
     */
    private static function getDefaultSourceStartCmd($os, $game = '', $file = '')
    {
        $cmd = '';
        if(!empty($game)){
            $game = ' -game ' . $game;
        }
        switch ($os) {
            case 'linux':
                if(empty($file)){
                    $file = './srcds_run';
                }
                $cmd = $file . ' -console' . $game . ' +ip {ip} +port {port} +maxplayers {maxplayers} +map {default_map} -tickrate {tickrate} +rcon_password {rcon_password}';
                break;
            case 'windows':
                if(empty($file)){
                    $file = 'srcds.exe';
                }
                $cmd = $file . ' -console' . $game . ' +ip {ip} +port {port} +maxplayers {maxplayers} +map {default_map} -tickrate {tickrate} +rcon_password {rcon_password}';
                break;
        }
        return $cmd;
    }
}
