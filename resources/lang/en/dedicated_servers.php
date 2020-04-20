<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Dedicated servers Language Lines
    |--------------------------------------------------------------------------
    |
    |
    */

    'title_list' => 'Dedicated servers list',
    'title_create' => "Create Dedicated Server",
    'title_edit' => "Edit Dedicated Server",
    'title_view' => "View Dedicated Server",

    'dedicated_servers' => 'Dedicated servers',

    'create'            => 'Create',
    'edit'              => 'Edit',
    'save'              => 'Save',
    'main'              => 'Main',
    'name'              => 'Name',
    'location'          => 'Location',
    'provider'          => 'Provider',
    'ip'                => 'IP',
    'os'                => 'OS',
    'servers_count'     => 'Servers count',

    'scripts'           => 'Scripts',
    'edit_scripts'      => 'Edit scripts',
    'server_certificate' => 'Server Certificate',
    'client_certificate' => 'Client Certificate',
    'change_certificate' => 'Change Certificate',

    'ip_list'           => 'IP List',
    'gdaemon_api_key'   => 'GDaemon API Key',
    'gdaemon_version'   => 'GameAP Daemon version',
    'gdaemon_uptime'    => 'GameAP Daemon uptime',

    'gdaemon_online_servers_count'    => 'GameAP Daemon servers',
    'gdaemon_working_tasks_count'    => 'GameAP Daemon working tasks',
    'gdaemon_waiting_tasks_count'    => 'GameAP Daemon waiting tasks',

    'gdaemon_empty_info'        => 'Failed to get information',

    /* Shortcodes description */
    'game_server_shortcodes'    => 'Game Server Shortcodes',
    'd_shortcodes_host'         => 'server host/ip',
    'd_shortcodes_port'         => 'server port',
    'd_shortcodes_query_port'   => 'server query port',
    'd_shortcodes_rcon_port'    => 'server rcon port',
    'd_shortcodes_dir'          => 'absolute path to server directory',
    'd_shortcodes_uuid'         => 'unique id',
    'd_shortcodes_uuid_short'   => 'short unique id',
    'd_shortcodes_game'         => 'game code',
    'd_shortcodes_user'         => 'user name (exist user in dedicated server, not admin panel)',

    'start_restart_shortcodes'   => 'Start/Restart Shortcodes',
    'd_shortcodes_start_command'   => 'Game server start command',

    'console_command_shortcodes'   => 'Script Send Command',
    'd_shortcodes_console_command'   => 'Console command',
    
    'create_success_msg' => 'Dedicated server created successfully',
    'update_success_msg' => 'Dedicated server updated successfully',
    'delete_success_msg' => 'Dedicated server deleted successfully',
    
    'autosetup_title' => 'Dedicated Server Auto Setup',
    
    'autosetup_description_debian_ubuntu' => '<p>Only for Debian/Ubuntu.</p>
                    <p>To auto setup GDaemon run the command on Dedicated Server:</p>',

    'autosetup_description_windows' => '<p>Only for Windows</p>
                                <ul>
                                    <li>Install <a href="https://www.microsoft.com/ru-ru/download/details.aspx?id=53587">Microsoft Visual C++ 2015</a></li>
                                    <li>Download <a href="http://packages.gameap.ru/windows/gameap-daemon-installer.exe">gameap-daemon-installer.exe</a>
                                        (<code>http://packages.gameap.ru/windows/gameap-daemon-installer.exe</code>)
                                    </li>
                                    <li>Run gameap-daemon-installer.exe on your Windows host</li>
                                    <li>Fill in all the fields:<br>
                                        Host: <code>:host</code><br>
                                        Token: <code>:token</code>
                                    </li>
                                    <li>Push the install button</li>
                                </ul>',
    
    'autosetup_expire_msg' => 'Your link will expire in 5 minutes.',
    'autosetup_expire_token_msg' => 'Your token will expire in 5 minutes.',
];