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
        DB::table('game_mods')->insert([
            'game_code' => 'valve',
            'name' => 'Classic (Standart)',
            'fast_rcon' => '[{"desc":"\u0421\u0442\u0430\u0442\u0443\u0441 \u0441\u0435\u0440\u0432\u0435\u0440\u0430","rcon_command":"status"},{"desc":"\u041e\u0442\u043a\u043b\u044e\u0447\u0438\u0432\u0448\u0438\u0435\u0441\u044f \u0438\u0433\u0440\u043e\u043a\u0438","rcon_command":"amx_last"},{"desc":"Amx Who","rcon_command":"amx_who"},{"desc":"Stats","rcon_command":"stats"}]',
            'vars' => '[{"alias":"default_map","desc":"\u041a\u0430\u0440\u0442\u0430 \u043f\u043e \u0443\u043c\u043e\u043b\u0447\u0430\u043d\u0438\u044e","default_value":"","only_admins":false},{"alias":"fps","desc":"\u0421\u0435\u0440\u0432\u0435\u0440\u043d\u044b\u0439 FPS","default_value":"","only_admins":true},{"alias":"maxplayers","desc":"\u041c\u0430\u043a\u0441\u0438\u043c\u0430\u043b\u044c\u043d\u043e\u0435 \u043a\u043e\u043b\u0438\u0447\u0435\u0441\u0442\u0432\u043e \u0438\u0433\u0440\u043e\u043a\u043e\u0432","default_value":"","only_admins":false}]',
            'local_repository' => '',
            'remote_repository' => '',
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
            'fast_rcon' => '[{"desc":"\u0421\u0442\u0430\u0442\u0443\u0441 \u0441\u0435\u0440\u0432\u0435\u0440\u0430","rcon_command":"status"},{"desc":"\u041e\u0442\u043a\u043b\u044e\u0447\u0438\u0432\u0448\u0438\u0435\u0441\u044f \u0438\u0433\u0440\u043e\u043a\u0438","rcon_command":"amx_last"},{"desc":"Amx Who","rcon_command":"amx_who"},{"desc":"Stats","rcon_command":"amx_who"}]',
            'vars' => '[{"alias":"default_map","desc":"\u041a\u0430\u0440\u0442\u0430 \u043f\u043e \u0443\u043c\u043e\u043b\u0447\u0430\u043d\u0438\u044e","only_admins":false},{"alias":"fps","desc":"\u0421\u0435\u0440\u0432\u0435\u0440\u043d\u044b\u0439 FPS","only_admins":false},{"alias":"hl_exec","desc":"\u0418\u0441\u043f\u043e\u043b\u043d\u044f\u0435\u043c\u044b\u0439 \u0444\u0430\u0439\u043b \u0438\u0433\u0440\u043e\u0432\u043e\u0433\u043e \u0441\u0435\u0440\u0432\u0435\u0440\u0430 (\u043e\u0431\u044b\u0447\u043d\u043e hlds_run \u0438\u043b\u0438 hlds.exe)","only_admins":true},{"alias":"maxplayers","desc":"\u041c\u0430\u043a\u0441\u0438\u043c\u0430\u043b\u044c\u043d\u043e\u0435 \u043a\u043e\u043b\u0438\u0447\u0435\u0441\u0442\u0432\u043e \u0438\u0433\u0440\u043e\u043a\u043e\u0432","only_admins":false}]',
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
}
