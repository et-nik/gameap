<?php

namespace Gameap\Services;

use Gameap\Models\User;

class PersonalAccessTokenService
{
    // Admin abilities
    public const SERVER_CREATE_ABILITY       = 'admin:server:create';
    public const GDAEMON_TASK_READ_ABILITY   = 'admin:gdaemon-task:read';

    // User abilities
    public const SERVER_START_ABILITY        = 'server:start';
    public const SERVER_STOP_ABILITY         = 'server:stop';
    public const SERVER_RESTART_ABILITY      = 'server:restart';
    public const SERVER_UPDATE_ABILITY       = 'server:update';
    public const SERVER_CONSOLE_ABILITY      = 'server:console';
    public const SERVER_RCON_CONSOLE_ABILITY = 'server:rcon-console';
    public const SERVER_RCON_PLAYERS_ABILITY = 'server:rcon-players';

    public function getGrouppedAbilitiesDescriptions(User $user): array
    {
        $userAbilities = [
            'server' => [
                self::SERVER_START_ABILITY        => __('tokens.abilities_descriptions.server.start'),
                self::SERVER_STOP_ABILITY         => __('tokens.abilities_descriptions.server.stop'),
                self::SERVER_RESTART_ABILITY      => __('tokens.abilities_descriptions.server.restart'),
                self::SERVER_UPDATE_ABILITY       => __('tokens.abilities_descriptions.server.update'),
                self::SERVER_CONSOLE_ABILITY      => __('tokens.abilities_descriptions.server.console'),
                self::SERVER_RCON_CONSOLE_ABILITY => __('tokens.abilities_descriptions.server.rcon-console'),
                self::SERVER_RCON_PLAYERS_ABILITY => __('tokens.abilities_descriptions.server.rcon-players'),
            ],
        ];

        if ($user->can('admin roles & permissions')) {
            $userAbilities['server'][self::SERVER_CREATE_ABILITY] = __('tokens.abilities_descriptions.server.create');
            $userAbilities['gdaemon-task'][self::GDAEMON_TASK_READ_ABILITY] = __('tokens.abilities_descriptions.gdaemon_task.read');
        }

        return $userAbilities;
    }
}
