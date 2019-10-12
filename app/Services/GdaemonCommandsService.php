<?php

namespace Gameap\Services;

use Gameap\Exceptions\GameapException;
use Gameap\Models\DedicatedServer;
use http\Exception\RuntimeException;
use Knik\Gameap\GdaemonCommands;

abstract class GdaemonCommandsService
{
    /**
     * @var GdaemonCommands
     */
    protected $gdaemonCommands;

    /**
     * GdaemonCommandsService constructor.
     *
     * @param GdaemonCommands $gdaemonCommands
     */
    public function __construct(GdaemonCommands $gdaemonCommands)
    {
        $this->gdaemonCommands = $gdaemonCommands;
    }

    /**
     * Setting up gdaemon commands configuration
     *
     * @param int|DedicatedServer
     * @throws GameapException
     */
    protected function configureGdaemon($ds)
    {
        if (is_int($ds)) {
            $dedicatedServer = DedicatedServer::findOrFail($ds);
        } else if ($ds instanceof DedicatedServer) {
            $dedicatedServer = $ds;
        } else {
            throw new GameapException('Invalid type');
        }

        $this->gdaemonCommands->setConfig(
            $dedicatedServer->gdaemonSettings()
        );
    }

    /**
     * @param string $command
     * @param array $codes
     * @return string
     */
    protected function replaceShortCodes(string $command, array $codes)
    {
        foreach ($codes as $code => $value) {
            $command = str_replace('{' . $code . '}', $value, $command);
        }

        return $command;
    }
}