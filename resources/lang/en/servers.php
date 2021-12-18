<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Servers Language Lines
    |--------------------------------------------------------------------------
    |
    |
    */

    'title_servers_list'    => 'Game Servers List',
    'title_create'          => 'Create Server',
    'title_edit'            => 'Edit Server',
    'title_server'          => 'Game Server',

    'servers'       => 'Servers',
    'game_servers'  => 'Game Servers',
    'file_manager'  => 'File Manager',

    'start'         => 'Start',
    'restart'       => 'Restart',
    'stop'          => 'Stop',
    'control'       => 'Control',
    'update'        => 'Update',
    'reinstall'     => 'Reinstall',
    'status'        => 'Status',
    'commands'      => 'Commands',
    'ip_port'       => 'IP:Port',

    'enabled'       => 'Enabled',

    'not_installed' => 'not installed',
    'installed'     => 'installed',
    'installation'  => 'installation',

    'disabled'      => 'disabled',
    'blocked'       => 'blocked',

    'offline'       => 'offline',
    'online'        => 'online',

    'name'          => 'Name',
    'game'          => 'Game',
    'game_mod'      => 'Game Mod',

    'tools'         => 'Tools',
    'files'         => 'Files',
    'admin'         => 'Admin',

    'task_scheduler' => 'Task Scheduler',

    'autostart_setting' => 'Autostart on crash',
    'update_before_start_setting' => 'Update server before starting',

    'process_status' => 'Proccess status',
    'active'        => 'active',
    'inactive'      => 'inactive',
    'last_check'    => 'Last check',

    'query'         => 'Query',
    'query_players' => 'Players',
    'query_map'     => 'Map',

    'console'       => 'Console',

    'not_installed_msg' => 'Server is not installed',
    'installation_process_msg' => 'Server in installation process',
    'disabled_msg' => 'Server is disabled',
    'blocked_msg' => 'Server is blocked',

    // Admin

    'create'        => 'Create',
    'edit'          => 'Edit server',
    'revoke'        => 'Revoke',
    
    'settings'      => 'Settings',
    
    'install'       => 'Install server',

    'server_info' => 'Server Info',
    'basic_info'    => 'Basic Info',
    'ds_ip_ports'    => 'Dedicated server, IP, ports',
    'dedicated_server' => 'Dedicated Server',
    'start_command' => 'Start Command',

    'start_success_msg' => 'Game Server started successfully',
    'start_fail_msg' => 'Game Server failed to start',
    'stop_success_msg' => 'Game Server stopped successfully',
    'stop_fail_msg' => 'Game Server failed to stop',
    'restart_success_msg' => 'Game Server restarted successfully',
    'restart_fail_msg' => 'Game Server failed to restart',
    'create_success_msg' => 'Game Server created successfully',
    'update_success_msg' => 'Game Server updated successfully',
    'delete_success_msg' => 'Game Server deleted successfully',

    'settings_update_success_msg' => 'Game Server Settings updated successfully',

    'task_success_msg' => 'Task completed successfully',
    'task_see_log'     => 'See <a href=:link>task log</a> for details.',

    'unknown_command_msg' => 'Unknown server command',

    'd_dir' => 'Leave blank to set automatically. 
        Path relative to the working directory of the dedicated server. 
        <br> Example: <strong>servers/my_server</strong>',

    'd_installation_is_stuck' => 'It looks like the server installation is stuck. ' .
        'This could have happened due to an error in the GameAP Daemon or for some other reason. ' .
        'The following steps will help you fix the problem: ' .
        '<ul>' .
        '<li>Check the GameAP Daemon is working;</li>' .
        '<li>Restart GameAP Daemon;</li>' .
        '<li>Set the server status manually. Go to the administration of the game server and change the server status.</li>' .
        '<ul>',

    'delete_confirm_msg' => 'Are you sure to delete game server?',

    'delete_files' => 'Delete files',
];
