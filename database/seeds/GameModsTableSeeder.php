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

        $defaultGoldSourceVars = [
            [
                'var' => 'default_map',
                'default' => 'crossfire',
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

        /* Half-Life 1 */
        DB::table('game_mods')->insert([
            'game_code' => 'valve',
            'name' => 'Classic (Standart)',
            'fast_rcon' => json_encode($defaultGoldSourceAmxFastRcon),
            'vars' => json_encode($defaultGoldSourceVars),
            'local_repository' => '',
            'remote_repository' => '',
            'default_start_cmd_linux' => './hlds_run -game valve +ip {ip} +port {port} +map {default_map} +maxplayers {maxplayers} +sys_ticrate {fps}',
            'default_start_cmd_windows' => 'hlds.exe -console -game valve +ip {ip} +port {port} +map {default_map} +maxplayers {maxplayers} +sys_ticrate {fps}',
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
            'vars' => json_encode($defaultGoldSourceVars),
            'local_repository' => '',
            'remote_repository' => '',
            'default_start_cmd_linux' => './hlds_run -game valve +ip {ip} +port {port} +map {default_map} +maxplayers {maxplayers} +sys_ticrate {fps}',
            'default_start_cmd_windows' => 'hlds.exe -console -game valve +ip {ip} +port {port} +map {default_map} +maxplayers {maxplayers} +sys_ticrate {fps}',
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
            'vars' => json_encode($defaultGoldSourceVars),
            'local_repository' => '',
            'remote_repository' => '',
            'default_start_cmd_linux' => './hlds_run -game cstrike +ip {ip} +port {port} +map {default_map} +maxplayers {maxplayers} +sys_ticrate {fps}',
            'default_start_cmd_windows' => 'hlds.exe -console -game cstrike +ip {ip} +port {port} +map {default_map} +maxplayers {maxplayers} +sys_ticrate {fps}',
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
            'vars' => json_encode($defaultGoldSourceVars),
            'local_repository' => '',
            'remote_repository' => '',
            'default_start_cmd_linux' => './hlds_run -game cstrike +ip {ip} +port {port} +map {default_map} +maxplayers {maxplayers} +sys_ticrate {fps}',
            'default_start_cmd_windows' => 'hlds.exe -console -game cstrike +ip {ip} +port {port} +map {default_map} +maxplayers {maxplayers} +sys_ticrate {fps}',
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
            'name' => 'Multimod',
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
    }
}
