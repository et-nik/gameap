<?php

namespace Gameap\UseCases\Commands;

use Symfony\Component\Serializer\Annotation\SerializedName;

class CreateGameServerCommand
{
    /** @var int */
    public $dsId;

    /** @var bool */
    public $install;

    /** @var string */
    public $name;

    /** @var string */
    public $gameId;

    /** @var string */
    public $rcon;

    /** @var int */
    public $gameModId;

    /** @var string */
    public $serverIp;

    /** @var int */
    public $serverPort;

    /** @var int */
    public $queryPort;

    /** @var int */
    public $rconPort;

    /** @var string */
    public $startCommand;

    /** @var string */
    public $dir;

    /** @var string */
    public $suUser;
}
