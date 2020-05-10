<?php

namespace Gameap\Services;

use Gameap\Models\Server;
use Knik\GRcon\EasyGRcon;

class RconService
{
    /**
     * @var EasyGRcon
     */
    private $rcon;

    /**
     * RconService constructor.
     * @param EasyGRcon $rcon
     * @throws \Knik\GRcon\Exceptions\ProtocolNotSupportedException
     */
    public function __construct(EasyGRcon $rcon)
    {
        $this->rcon = $rcon;
    }

    /**
     * @param Server $server
     * @return array
     * @throws \Knik\GRcon\Exceptions\ProtocolNotSupportedException
     */
    public function supportedFeatures(Server $server)
    {
        $this->setRconOptions($server);
        return [
            'playersManage' => $this->rcon->isPlayersManageSupported()
        ];
    }

    /**
     * @param Server $server
     * @param string $command
     */
    public function sendCommand(Server $server, string $command)
    {
        $this->setRconOptions($server);
        return $this->rcon->execute($command);
    }

    /**
     * @param Server $server
     * @return array
     * @throws \Knik\GRcon\Exceptions\PlayersManageNotSupportedExceptions
     */
    public function getPlayers(Server $server)
    {
        $this->setRconOptions($server);

        return $this->rcon->getPlayers();
    }

    /**
     * @param Server $server
     * @param mixed $playerId
     * @param string $reason
     * @return mixed
     * @throws \Knik\GRcon\Exceptions\ProtocolNotSupportedException
     */
    public function kick(Server $server, $playerId, string $reason = '')
    {
        $this->setRconOptions($server);

        return $this->rcon->kick($playerId, $reason);
    }

    /**
     * @param Server $server
     * @param mixed $playerId
     * @param string $reason
     * @param int $time
     * @return mixed
     * @throws \Knik\GRcon\Exceptions\PlayersManageNotSupportedExceptions
     * @throws \Knik\GRcon\Exceptions\ProtocolNotSupportedException
     */
    public function ban(Server $server, $playerId, string $reason = '', int $time = 0)
    {
        $this->setRconOptions($server);

        return $this->rcon->ban($playerId, $reason, $time);
    }

    /**
     * @param Server $server
     * @throws \Knik\GRcon\Exceptions\ProtocolNotSupportedException
     */
    private function setRconOptions(Server $server)
    {
        $this->rcon->setProtocol(strtolower($server->game->engine), [
            'host'      => $server->server_ip,
            'port'      => $server->rcon_port,
            'password'  => $server->rcon
        ]);
    }
}