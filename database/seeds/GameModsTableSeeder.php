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

        /* Half-Life */

        DB::table('game_mods')->insert([
            'game_code' => 'valve',
            'name' => 'Default',
            'fast_rcon' => json_encode($defaultGoldSourceFastRcon),
            'vars' => json_encode(self::getDefaultGoldSourceVars()),
            'default_start_cmd_linux' => self::getDefaultGoldSourceStartCmd('nix', 'valve'),
            'default_start_cmd_windows' => self::getDefaultGoldSourceStartCmd('win', 'valve'),
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
            'remote_repository' => $gapRepoBaseUrl . '/half-life/amxx.tar.xz',
            'default_start_cmd_linux' => self::getDefaultGoldSourceStartCmd('nix', 'valve'),
            'default_start_cmd_windows' => self::getDefaultGoldSourceStartCmd('win', 'valve'),
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
            'remote_repository' => $gapRepoBaseUrl . '/half-life/rehlds-amxx-reunion.tar.xz',
            'default_start_cmd_linux' => self::getDefaultGoldSourceStartCmd('nix', 'valve'),
            'default_start_cmd_windows' => self::getDefaultGoldSourceStartCmd('win', 'valve'),
            'passwd_cmd' => 'password {password}',
            'sendmsg_cmd' => 'say "{msg}"',
            'chmap_cmd' => 'changelevel {map}',
            'srestart_cmd' => 'restart',
            'kick_cmd' => 'kick #{id}',
        ]);

        /* Counter-Strike 1.6 */

        DB::table('game_mods')->insert([
            'game_code' => 'cstrike',
            'name' => 'Default',
            'fast_rcon' => json_encode($defaultGoldSourceFastRcon),
            'vars' => json_encode(self::getDefaultGoldSourceVars('de_dust2')),
            'default_start_cmd_linux' => self::getDefaultGoldSourceStartCmd('nix', 'cstrike'),
            'default_start_cmd_windows' => self::getDefaultGoldSourceStartCmd('win', 'cstrike'),
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
            'remote_repository' => $gapRepoBaseUrl . '/cstrike-1.6/amxx.tar.xz',
            'default_start_cmd_linux' => self::getDefaultGoldSourceStartCmd('nix', 'cstrike'),
            'default_start_cmd_windows' => self::getDefaultGoldSourceStartCmd('win', 'cstrike'),
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
            'remote_repository' => $gapRepoBaseUrl . '/cstrike-1.6/rehlds-amxx-reunion.tar.xz',
            'default_start_cmd_linux' => self::getDefaultGoldSourceStartCmd('nix', 'cstrike'),
            'default_start_cmd_windows' => self::getDefaultGoldSourceStartCmd('win', 'cstrike'),
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
            'default_start_cmd_linux' => self::getDefaultSourceStartCmd('nix', 'cstrike'),
            'default_start_cmd_windows' => self::getDefaultSourceStartCmd('win', 'cstrike'),
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
            'default_start_cmd_linux' => self::getDefaultSourceStartCmd('nix', 'csgo') . ' +sv_setsteamaccount {steamaccount} +mapgroup {mapgroup} +game_type 0 +game_mode 0',
            'default_start_cmd_windows' => self::getDefaultSourceStartCmd('win', 'csgo') . ' +sv_setsteamaccount {steamaccount} +mapgroup {mapgroup} +game_type 0 +game_mode 0',
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
            'default_start_cmd_linux' => self::getDefaultSourceStartCmd('nix', 'csgo') . ' +sv_setsteamaccount {steamaccount} +mapgroup {mapgroup} +game_type 0 +game_mode 1',
            'default_start_cmd_windows' => self::getDefaultSourceStartCmd('win', 'csgo') . ' +sv_setsteamaccount {steamaccount} +mapgroup {mapgroup} +game_type 0 +game_mode 1',
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
            'default_start_cmd_linux' => self::getDefaultSourceStartCmd('nix', 'csgo') . ' +sv_setsteamaccount {steamaccount} +mapgroup {mapgroup} +game_type 1 +game_mode 0',
            'default_start_cmd_windows' => self::getDefaultSourceStartCmd('win', 'csgo') . ' +sv_setsteamaccount {steamaccount} +mapgroup {mapgroup} +game_type 1 +game_mode 0',
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
            'default_start_cmd_linux' => self::getDefaultSourceStartCmd('nix', 'csgo') . ' +sv_setsteamaccount {steamaccount} +mapgroup {mapgroup} +game_type 1 +game_mode 1',
            'default_start_cmd_windows' => self::getDefaultSourceStartCmd('win', 'csgo') . ' +sv_setsteamaccount {steamaccount} +mapgroup {mapgroup} +game_type 1 +game_mode 1',
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
            'default_start_cmd_linux' => self::getDefaultSourceStartCmd('nix', 'csgo') . ' +sv_setsteamaccount {steamaccount} +mapgroup {mapgroup} +game_type 1 +game_mode 2',
            'default_start_cmd_windows' => self::getDefaultSourceStartCmd('win', 'csgo') . ' +sv_setsteamaccount {steamaccount} +mapgroup {mapgroup} +game_type 1 +game_mode 2',
            'passwd_cmd' => 'password {password}',
            'sendmsg_cmd' => 'say "{msg}"',
            'chmap_cmd' => 'changelevel {map}',
            'srestart_cmd' => 'restart',
            'kick_cmd' => 'kick #{id}',
        ]);

        /* Insurgency */

        DB::table('game_mods')->insert([
            'game_code' => 'insurgency',
            'name' => 'Default',
            'vars' => json_encode(self::getDefaultSourceVars('ministry')),
            'default_start_cmd_linux' => self::getDefaultSourceStartCmd('nix'),
            'default_start_cmd_windows' => self::getDefaultSourceStartCmd('win'),
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
            'vars' => json_encode(self::getDefaultSourceVars('cp_badlands')),
            'default_start_cmd_linux' => self::getDefaultSourceStartCmd('nix'),
            'default_start_cmd_windows' => self::getDefaultSourceStartCmd('win'),
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
            'default_start_cmd_linux' => self::getDefaultSourceStartCmd('nix', 'garrysmod'),
            'default_start_cmd_windows' => self::getDefaultSourceStartCmd('win', 'garrysmod'),
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
            'default_start_cmd_linux' => self::getDefaultSourceStartCmd('nix', 'bms'),
            'default_start_cmd_windows' => self::getDefaultSourceStartCmd('win', 'bms'),
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
            'default_start_cmd_linux' => self::getDefaultSourceStartCmd('nix', 'dods'),
            'default_start_cmd_windows' => self::getDefaultSourceStartCmd('win', 'dods'),
            'passwd_cmd' => 'password {password}',
            'sendmsg_cmd' => 'say "{msg}"',
            'chmap_cmd' => 'changelevel {map}',
            'srestart_cmd' => 'restart',
            'kick_cmd' => 'kick #{id}',
        ]);

        /* Minecraft */

        DB::table('game_mods')->insert([
            'game_code' => 'minecraft',
            'name' => 'Vanilla',
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
            'remote_repository' => $gapRepoBaseUrl . '/minecraft/minecraft-runner.tar.gz',
            'default_start_cmd_linux' => './mcrun.sh run --version={version} --core-mod={core_mod} --core-mod-version={core_mod_version} --ip={ip} --port={port} --query-port={query_port} --rcon-port={rcon_port} --rcon-password={rcon_password}',
        ]);

        /* PMMP (MinecraftPE) */

        DB::table('game_mods')->insert([
            'game_code' => 'pmmp',
            'name' => 'Default',
            'default_start_cmd_linux' => './bin/php7/bin/php ./PocketMine-MP.phar',
            'default_start_cmd_windows' => '',
            'passwd_cmd' => 'password {password}',
            'sendmsg_cmd' => 'say {msg}',
            'srestart_cmd' => 'reload',
            'ban_cmd' => 'ban {name} {reason}',
            'kick_cmd' => 'kick {name}',
        ]);

        /* SAMP */

        DB::table('game_mods')->insert([
            'game_code' => 'samp',
            'name' => 'Freeroam (Linux)',
            'default_start_cmd_linux' => './samp03svr',
            'remote_repository' => 'http://files.sa-mp.com/samp037svr_R2-1.tar.gz',
        ]);

        DB::table('game_mods')->insert([
            'game_code' => 'samp',
            'name' => 'Freeroam (Windows)',
            'default_start_cmd_windows' => 'samp-server.exe',
            'remote_repository' => 'http://files.sa-mp.com/samp037_svr_R2-1-1_win32.zip',
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
            'default_start_cmd_linux' => './mta-server64 -t -n --ip {ip} --port {port} --maxplayers {maxplayers}',
            'remote_repository' => $gapRepoBaseUrl . '/mta/default-deathmatch.tar.xz',
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
            'default_start_cmd_linux' => './fivem_run.sh --ip={ip} --port={port} --hostname="{hostname}" --rcon-password="{rcon_password}" --license-key="{license_key}"',
            'default_start_cmd_windows' => 'run.cmd +exec server.cfg',
            'sendmsg_cmd' => 'say {msg}',
            'kick_cmd' => 'clientkick {id}',
        ]);

        /* Just cause 2 */

        DB::table('game_mods')->insert([
            'game_code' => 'justcause2',
            'name' => 'Default',
            'default_start_cmd_linux' => './Jcmp-Server',
            'default_start_cmd_windows' => '',
        ]);

        /* Just cause 3 */

        DB::table('game_mods')->insert([
            'game_code' => 'justcause3',
            'name' => 'Default',
            'default_start_cmd_linux' => './Server',
            'default_start_cmd_windows' => '',
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

        /* 7 Day to Die */

        DB::table('game_mods')->insert([
            'game_code' => '7d2d',
            'name' => 'Default',
            'default_start_cmd_linux' => './startserver.sh -configfile=serverconfig.xml',
            'default_start_cmd_windows' => 'startdedicated.bat',
        ]);

        /* Killing floor 2 */

        DB::table('game_mods')->insert([
            'game_code' => 'killingfloor2',
            'name' => 'Default',
            'vars' => json_encode([
                'var' => 'default_map',
                'default' => 'kf-bioticslab',
                'info' => 'Default Map',
            ]),
            'default_start_cmd_linux' => './Binaries/Win64/KFGameSteamServer.bin.x86_64 {default_map}',
            'default_start_cmd_windows' => 'Binaries\win64\kfserver {default_map}',
        ]);

        /* TeamSpeak 3 */

        DB::table('game_mods')->insert([
            'game_code' => 'ts3',
            'name' => 'Linux',
            'default_start_cmd_linux' => './ts3server',
            'remote_repository' => 'https://files.teamspeak-services.com/releases/server/3.13.6/teamspeak3-server_linux_amd64-3.13.6.tar.bz2',
        ]);

        DB::table('game_mods')->insert([
            'game_code' => 'ts3',
            'name' => 'Windows',
            'default_start_cmd_windows' => 'teamspeak3-server_win64\ts3server.exe',
            'remote_repository' => 'https://files.teamspeak-services.com/releases/server/3.13.6/teamspeak3-server_win64-3.13.6.zip',
        ]);

    }

    /**
     * @param string $os
     * @param string $game
     * @return string
     */
    private static function getDefaultGoldSourceStartCmd($os, $game)
    {
        $cmd = '';
        if($game){
            $game = ' -game ' . $game;
        }
        switch ($os) {
            case 'nix':
                $cmd = './hlds_run -console' . $game . ' +ip {ip} +port {port} +map {default_map} +maxplayers {maxplayers} +sys_ticrate {fps} +rcon_password {rcon_password}';
                break;
            case 'win':
                $cmd = 'hlds.exe -console' . $game . ' +ip {ip} +port {port} +map {default_map} +maxplayers {maxplayers} +sys_ticrate {fps} +rcon_password {rcon_password}';
                break;
        }
        return $cmd;
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
     * @return string
     */
    private static function getDefaultSourceStartCmd($os, $game = '')
    {
        $cmd = '';
        if($game){
            $game = ' -game ' . $game;
        }
        switch ($os) {
            case 'nix':
                $cmd = './srcds_run -console -usercon' . $game . ' +ip {ip} +port {port} +maxplayers {maxplayers} +map {default_map} -tickrate {tickrate} +rcon_password {rcon_password}';
                break;
            case 'win':
                $cmd = 'srcds.exe -console -usercon' . $game . ' +ip {ip} +port {port} +maxplayers {maxplayers} +map {default_map} -tickrate {tickrate} +rcon_password {rcon_password}';
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
            ],
            [
                'var' => 'tickrate',
                'default' => 64,
                'info' => 'Server tickrate',
                'admin_var' => true,
            ]
        ];
    }
}
