<?php

return [
    'generate_token' => 'Generate New Token',

    'tokens'    => 'Tokens',
    'name'      => 'Token Name',
    'abilities' => 'Abilities',
    'last_used' => 'Last Used',

    'delete_confirm_msg' => 'Are you sure you want to delete the token?',

    'token_created_notification' => 'Make sure to copy your new personal access token now. You won’t be able to see it again!',
    'token_created_msg'          => 'Token created: :token',
    'token_removed_msg'          => 'Token removed successfully.',

    'abilities_descriptions' => [
        'server' => [
            'create'         => 'Create game server',
            'start'          => 'Start game server',
            'stop'           => 'Stop game server',
            'restart'        => 'Restart game server',
            'update'         => 'Update game server',
            'console'        => 'Access to read and write into game server console',
            'rcon-console'   => 'Access to game server RCON console',
            'rcon-players'   => 'Access to players management on game server',
        ],
        'gdaemon_task' => [
            'read'           => 'Read GameAP Daemon task',
        ]
    ],

    'validation' => [
        'abilities_required'        => 'You must select at least one ability',
        'abilities_invalid_format'  => 'Invalid abilities format',
    ]
];
