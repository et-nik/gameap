<?php

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

        /* Half-Life 1 */
        DB::table('game_mods')->insert([
            'game_code' => 'valve',
            'name' => 'Classic (Standart)',
            'fast_rcon' => json_encode($defaultGoldSourceAmxFastRcon),
            'vars' => json_encode(self::getDefaultGoldSourceVars()),
            'local_repository' => '',
            'remote_repository' => 'http://files.gameap.ru/half-life/amxx.tar.xz',
            'default_start_cmd_linux' => './hlds_run -game valve +ip {ip} +port {port} +map {default_map} +maxplayers {maxplayers} +sys_ticrate {fps} +rcon_password {rcon_password}',
            'default_start_cmd_windows' => 'hlds.exe -console -game valve +ip {ip} +port {port} +map {default_map} +maxplayers {maxplayers} +sys_ticrate {fps} +rcon_password {rcon_password}',
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
            'name' => 'No AMX MOD X',
            'fast_rcon' => json_encode($defaultGoldSourceFastRcon),
            'vars' => json_encode(self::getDefaultGoldSourceVars()),
            'local_repository' => '',
            'remote_repository' => '',
            'default_start_cmd_linux' => './hlds_run -game valve +ip {ip} +port {port} +map {default_map} +maxplayers {maxplayers} +sys_ticrate {fps} +rcon_password {rcon_password}',
            'default_start_cmd_windows' => 'hlds.exe -console -game valve +ip {ip} +port {port} +map {default_map} +maxplayers {maxplayers} +sys_ticrate {fps} +rcon_password {rcon_password}',
            'passwd_cmd' => 'password {password}',
            'sendmsg_cmd' => 'say "{msg}"',
            'chmap_cmd' => 'changelevel {map}',
            'srestart_cmd' => 'restart',
            'chname_cmd' => '',
            'ban_cmd' => '',
            'kick_cmd' => 'kick #{id}',
        ]);

        DB::table('game_mods')->insert([
            'game_code' => 'valve',
            'name' => 'ReHLDS',
            'fast_rcon' => json_encode($defaultGoldSourceFastRcon),
            'vars' => json_encode(self::getDefaultGoldSourceVars()),
            'local_repository' => '',
            'remote_repository' => 'http://files.gameap.ru/half-life/rehlds-amxx-reunion.tar.xz',
            'default_start_cmd_linux' => './hlds_run -game cstrike +ip {ip} +port {port} +map {default_map} +maxplayers {maxplayers} +sys_ticrate {fps} +rcon_password {rcon_password}',
            'default_start_cmd_windows' => 'hlds.exe -console -game cstrike +ip {ip} +port {port} +map {default_map} +maxplayers {maxplayers} +sys_ticrate {fps} +rcon_password {rcon_password}',
            'passwd_cmd' => 'password {password}',
            'sendmsg_cmd' => 'say "{msg}"',
            'chmap_cmd' => 'changelevel {map}',
            'srestart_cmd' => 'restart',
            'chname_cmd' => '',
            'ban_cmd' => '',
            'kick_cmd' => 'kick #{id}',
        ]);

        /* Counter-Strike 1.6 */

        DB::table('game_mods')->insert([
            'game_code' => 'cstrike',
            'name' => 'Classic (Standart)',
            'fast_rcon' => json_encode($defaultGoldSourceAmxFastRcon),
            'vars' => json_encode(self::getDefaultGoldSourceVars('de_dust2')),
            'local_repository' => '',
            'remote_repository' => 'http://files.gameap.ru/cstrike-1.6/amxx.tar.xz',
            'default_start_cmd_linux' => './hlds_run -game cstrike +ip {ip} +port {port} +map {default_map} +maxplayers {maxplayers} +sys_ticrate {fps} +rcon_password {rcon_password}',
            'default_start_cmd_windows' => 'hlds.exe -console -game cstrike +ip {ip} +port {port} +map {default_map} +maxplayers {maxplayers} +sys_ticrate {fps} +rcon_password {rcon_password}',
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
            'name' => 'No AMX MOD X',
            'fast_rcon' => json_encode($defaultGoldSourceFastRcon),
            'vars' => json_encode(self::getDefaultGoldSourceVars('de_dust2')),
            'local_repository' => '',
            'remote_repository' => '',
            'default_start_cmd_linux' => './hlds_run -game cstrike +ip {ip} +port {port} +map {default_map} +maxplayers {maxplayers} +sys_ticrate {fps} +rcon_password {rcon_password} +rcon_password {rcon_password}',
            'default_start_cmd_windows' => 'hlds.exe -console -game cstrike +ip {ip} +port {port} +map {default_map} +maxplayers {maxplayers} +sys_ticrate {fps} +rcon_password {rcon_password} +rcon_password {rcon_password}',
            'passwd_cmd' => 'password {password}',
            'sendmsg_cmd' => 'say "{msg}"',
            'chmap_cmd' => 'changelevel {map}',
            'srestart_cmd' => 'restart',
            'chname_cmd' => '',
            'ban_cmd' => '',
            'kick_cmd' => 'kick #{id}',
        ]);

        DB::table('game_mods')->insert([
            'game_code' => 'cstrike',
            'name' => 'ReHLDS',
            'fast_rcon' => json_encode($defaultGoldSourceFastRcon),
            'vars' => json_encode(self::getDefaultGoldSourceVars('de_dust2')),
            'local_repository' => '',
            'remote_repository' => 'http://files.gameap.ru/cstrike-1.6/rehlds-amxx-reunion.tar.xz',
            'default_start_cmd_linux' => './hlds_run -game cstrike +ip {ip} +port {port} +map {default_map} +maxplayers {maxplayers} +sys_ticrate {fps} +rcon_password {rcon_password}',
            'default_start_cmd_windows' => 'hlds.exe -console -game cstrike +ip {ip} +port {port} +map {default_map} +maxplayers {maxplayers} +sys_ticrate {fps} +rcon_password {rcon_password}',
            'passwd_cmd' => 'password {password}',
            'sendmsg_cmd' => 'say "{msg}"',
            'chmap_cmd' => 'changelevel {map}',
            'srestart_cmd' => 'restart',
            'chname_cmd' => '',
            'ban_cmd' => '',
            'kick_cmd' => 'kick #{id}',
        ]);

        /* Minecraft */

        DB::table('game_mods')->insert([
            'game_code' => 'minecraft',
            'name' => 'Multicore',
            'fast_rcon' => '',
            'vars' => '[{"var":"version","default":"1.14.3","info":"Minecraft version"},{"var":"core_mod","default":"vanilla","info":"Core"},{"var":"core_mod_version","default":null,"info":"Core mod version"}]',
            'local_repository' => '',
            'remote_repository' => 'http://files.gameap.ru/minecraft/minecraft-runner.tar.gz',
            'default_start_cmd_linux' => './mcrun.sh run --version={version} --core-mod={core_mod} --core-mod-version={core_mod_version} --ip={ip} --port={port} --query-port={query_port} --rcon-port={rcon_port}',
            'passwd_cmd' => '',
            'sendmsg_cmd' => '',
            'chmap_cmd' => '',
            'srestart_cmd' => '',
            'chname_cmd' => '',
            'ban_cmd' => '',
            'kick_cmd' => '',
        ]);

        DB::table('game_mods')->insert([
            'game_code' => 'minecraft',
            'name' => 'Vanilla',
            'fast_rcon' => '',
            'vars' => '',
            'local_repository' => '',
            'remote_repository' => '',
            'passwd_cmd' => '',
            'sendmsg_cmd' => '',
            'chmap_cmd' => '',
            'srestart_cmd' => '',
            'chname_cmd' => '',
            'ban_cmd' => '',
            'kick_cmd' => '',
        ]);

        // Rust

        DB::table('game_mods')->insert([
            'game_code' => 'rust',
            'name' => 'Vanilla',
            'fast_rcon' => '',
            'vars' => '',
            'local_repository' => '',
            'remote_repository' => '',
            'passwd_cmd' => '',
            'sendmsg_cmd' => '',
            'chmap_cmd' => '',
            'srestart_cmd' => '',
            'chname_cmd' => '',
            'ban_cmd' => '',
            'kick_cmd' => '',
        ]);

        DB::table('game_mods')->insert([
            'game_code' => 'rust',
            'name' => 'Oxide',
            'fast_rcon' => '',
            'vars' => '',
            'local_repository' => '',
            'remote_repository' => '',
            'passwd_cmd' => '',
            'sendmsg_cmd' => '',
            'chmap_cmd' => '',
            'srestart_cmd' => '',
            'chname_cmd' => '',
            'ban_cmd' => '',
            'kick_cmd' => '',
        ]);

        /* Counter-Strike Global Offensive */

        DB::table('game_mods')->insert([
            'game_code' => 'csgo',
            'name' => 'Classic',
            'fast_rcon' => '',
            'vars' => json_encode(self::getDefaultSourceVars('de_dust2')),
            'default_start_cmd_linux' => './srcds_run -game csgo -console -usercon +game_type 0 +game_mode 0 +ip {ip} +port {port} +maxplayers {maxplayers} +mapgroup mg_active +map {default_map} +rcon_password {rcon_password}',
            'default_start_cmd_windows' => 'srcds.exe -game csgo -console -usercon +game_type 0 +game_mode 0 +ip {ip} +port {port} +maxplayers {maxplayers} +mapgroup mg_active +map {default_map} +rcon_password {rcon_password}',
            'local_repository' => '',
            'remote_repository' => '',
            'passwd_cmd' => 'password {password}',
            'sendmsg_cmd' => 'say "{msg}"',
            'chmap_cmd' => 'changelevel {map}',
            'srestart_cmd' => 'restart',
            'chname_cmd' => '',
            'ban_cmd' => '',
            'kick_cmd' => 'kick #{id}',
        ]);

        /* FiveM */

        DB::table('game_mods')->insert([
            'game_code' => 'fivem',
            'name' => 'Vanilla',
            'fast_rcon' => '',
            'vars' => json_encode([
                [
                    'var' => 'hostname',
                    'default' => 'GameAP FiveM Server',
                    'info' => 'Server Hostname',
                    'admin_var' => false,
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
            'local_repository' => '',
            'remote_repository' => '',

            'passwd_cmd' => '',
            'sendmsg_cmd' => 'say {msg}',
            'chmap_cmd' => '',
            'srestart_cmd' => '',
            'chname_cmd' => '',
            'ban_cmd' => '',
            'kick_cmd' => 'clientkick {id}',
        ]);

        /* 7 Day to Die */

        DB::table('game_mods')->insert([
            'game_code' => '7d2d',
            'name' => 'Default',

            'default_start_cmd_linux' => './startserver.sh -configfile=serverconfig.xml',
            'default_start_cmd_windows' => 'startdedicated.bat',
        ]);

        /* Multi Theft Auto (MTA) */

        DB::table('game_mods')->insert([
            'game_code' => 'mta',
            'name' => 'DeathMatch Default',
            'vars' => json_encode([
                [
                    'var' => 'maxplayers',
                    'default' => 32,
                    'info' => 'Maximum players on server',
                    'admin_var' => false,
                ]
            ]),
            'default_start_cmd_linux' => './mta-server64 -t -n --ip {ip} --port {port} --maxplayers {maxplayers}',
            'default_start_cmd_windows' => '',

            'remote_repository' => 'http://files.gameap.ru/mta/default-deathmatch.tar.xz',
        ]);

        /* Black Mesa: Deathmatch */

        DB::table('game_mods')->insert([
            'game_code' => 'bms',
            'name' => 'Default',
            'fast_rcon' => '',
            'vars' => json_encode(self::getDefaultSourceVars()),
            'default_start_cmd_linux' => './srcds_run -game bms -console -usercon +ip {ip} +port {port} +maxplayers {maxplayers} +map {default_map} +rcon_password {rcon_password}',
            'default_start_cmd_windows' => 'srcds.exe -game bms -console -usercon +ip {ip} +port {port} +maxplayers {maxplayers} +map {default_map} +rcon_password {rcon_password}',
            'local_repository' => '',
            'remote_repository' => '',
            'passwd_cmd' => 'password {password}',
            'sendmsg_cmd' => 'say "{msg}"',
            'chmap_cmd' => 'changelevel {map}',
            'srestart_cmd' => 'restart',
            'chname_cmd' => '',
            'ban_cmd' => '',
            'kick_cmd' => 'kick #{id}',
        ]);

        /* Garry's Mod */

        DB::table('game_mods')->insert([
            'game_code' => 'bms',
            'name' => 'Default',
            'fast_rcon' => '',
            'vars' => json_encode(self::getDefaultGoldSourceVars('gm_flatgrass')),
            'default_start_cmd_linux' => './srcds_run -game bms -console -usercon +ip {ip} +port {port} +maxplayers {maxplayers} +map {default_map} +rcon_password {rcon_password}',
            'default_start_cmd_windows' => 'srcds.exe -game bms -console -usercon +ip {ip} +port {port} +maxplayers {maxplayers} +map {default_map} +rcon_password {rcon_password}',
            'local_repository' => '',
            'remote_repository' => '',
            'passwd_cmd' => 'password {password}',
            'sendmsg_cmd' => 'say "{msg}"',
            'chmap_cmd' => 'changelevel {map}',
            'srestart_cmd' => 'restart',
            'chname_cmd' => '',
            'ban_cmd' => '',
            'kick_cmd' => 'kick #{id}',
        ]);
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
                'admin_var' => false,
            ],
            [
                'var' => 'fps',
                'default' => 500,
                'info' => 'Server FPS (tickrate)',
                'admin_var' => true,
            ],
            [
                'var' => 'maxplayers',
                'default' => 32,
                'info' => 'Maximum players on server',
                'admin_var' => false,
            ],
        ];
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
                'admin_var' => false,
            ],
            [
                'var' => 'maxplayers',
                'default' => 32,
                'info' => 'Maximum players on server',
                'admin_var' => false,
            ],
        ];
    }
}
