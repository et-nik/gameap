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
    'nodes' => 'Nodes',

    'create'                    => 'Create',
    'edit'                      => 'Edit',
    'view'                      => 'View',
    'save'                      => 'Save',
    'main'                      => 'Main',
    'name'                      => 'Name',
    'location'                  => 'Location',
    'provider'                  => 'Provider',
    'ip'                        => 'IP',
    'os'                        => 'OS',
    'servers_count'             => 'Servers count',
    'download_logs'             => 'Download logs',
    'download_certificates'     => 'Download certificates',

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
    'd_shortcodes_id'           => 'server id',
    'd_shortcodes_uuid'         => 'unique id',
    'd_shortcodes_uuid_short'   => 'short unique id',
    'd_shortcodes_game'         => 'game code',
    'd_shortcodes_user'         => 'user name (exist user in dedicated server, not admin panel)',

    'start_restart_shortcodes'   => 'Start/Restart Shortcodes',
    'd_shortcodes_start_command'   => 'Game server start command',

    'console_command_shortcodes'   => 'Script Send Command',
    'd_shortcodes_console_command'   => 'Console command',

    'delete_confirm_msg' => 'Are you sure you want to delete this node?',
    
    'create_success_msg' => 'Dedicated server created successfully',
    'update_success_msg' => 'Dedicated server updated successfully',
    'delete_success_msg' => 'Dedicated server deleted successfully',

    'delete_has_servers_error_msg' => 'You can\'t delete dedicated server with game servers',
    
    'autosetup_title' => 'Dedicated Server Auto Setup',
    
    'autosetup_description_linux' => '<p>You can use this host and token to setup GDaemon via gameapctl:</p>
                    <ul class="list-disc">
                        <li>Host: <code>:host</code></li>
                        <li>Token: <code>:token</code></li>
                    </ul>
                    <p>Or to auto setup GDaemon run the command on Dedicated Server:</p>',

    'autosetup_description_windows' => '<p>Only for Windows</p>
                                <ul class="list-disc">
                                    <li>Go to <a target="_blank" href="https://github.com/gameap/gameapctl/releases">gameapctl releases page</a>
                                        (<code>https://github.com/gameap/gameapctl/releases</code>)
                                    </li>
                                    <li>Select a last version and download an archive for you architecture, most likely gameapctl-vX.Y.Z-windows-amd64.zip will work for you</li>
                                    <li>Run gameapctl.exe on your Windows host</li>
                                    <li>Click Install button in a GameAP Daemon section</li>
                                    <li>Fill in all the fields:<br>
                                        Host: <code>:host</code><br>
                                        Token: <code>:token</code>
                                    </li>
                                    <li>Push the install button</li>
                                </ul>',
    
    'autosetup_expire_msg' => 'Your link will expire in 5 minutes.',
    'autosetup_expire_token_msg' => 'Your token will expire in 5 minutes.',
];
