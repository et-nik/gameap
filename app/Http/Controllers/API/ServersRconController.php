<?php

namespace Gameap\Http\Controllers\API;

use Gameap\Http\Controllers\AuthController;
use Gameap\Http\Requests\API\Rcon\BanRequest;
use Gameap\Http\Requests\API\Rcon\CommandRequest;
use Gameap\Http\Requests\API\Rcon\KickRequest;
use Gameap\Models\Server;
use Gameap\Services\RconService;

class ServersRconController extends AuthController
{
    /**
     * Get supported features list
     *
     * @param RconService $rconService
     * @param Server $server
     * @return array
     * @throws \Knik\GRcon\Exceptions\ProtocolNotSupportedException
     */
    public function supportedFeatures(RconService $rconService, Server $server)
    {
        return $rconService->supportedFeatures($server);
    }

    /**
     * @param RconService $rconService
     * @param CommandRequest $request
     * @return array
     */
    public function sendCommand(CommandRequest $request, RconService $rconService, Server $server)
    {
        $this->authorize('server-rcon-console', $server);

        return [
            'output' => $server->processActive()
                ? $rconService->sendCommand($server, $request->post('command'))
                : 'Server is offline'
        ];
    }

    /**
     * Get Player list
     *
     * @param RconService $rconService
     * @param Server $server
     * @return array
     * @throws \Knik\GRcon\Exceptions\PlayersManageNotSupportedExceptions
     */
    public function getPlayers(RconService $rconService, Server $server)
    {
        $this->authorize('server-rcon-players', $server);

        if (!$server->processActive()) {
            return [];
        }

        return $rconService->getPlayers($server);
    }

    /**
     * Kick Player
     *
     * @param KickRequest $request
     * @param RconService $rconService
     * @param Server $server
     * @return mixed
     * @throws \Knik\GRcon\Exceptions\ProtocolNotSupportedException
     */
    public function kick(KickRequest $request, RconService $rconService, Server $server)
    {
        $this->authorize('server-rcon-players', $server);

        if (!$server->processActive()) {
            return 'Server is offline';
        }

        return $rconService->kick($server, $request->post('player'), $request->post('reason'));
    }

    /**
     * Ban Player
     *
     * @param BanRequest $request
     * @param RconService $rconService
     * @param Server $server
     * @return mixed
     * @throws \Knik\GRcon\Exceptions\PlayersManageNotSupportedExceptions
     * @throws \Knik\GRcon\Exceptions\ProtocolNotSupportedException
     */
    public function ban(BanRequest $request, RconService $rconService, Server $server)
    {
        $this->authorize('server-rcon-players', $server);

        if (!$server->processActive()) {
            return 'Server is offline';
        }

        return $rconService->ban(
            $server,
            $request->post('player'),
            $request->post('reason'),
            $request->post('time')
        );
    }

    public function message(RconService $rconService, Server $server)
    {
        $this->authorize('server-rcon-players', $server);

        if ($server->processActive()) {
            return 'Server is offline';
        }

        return 'Not implemented';
    }
}