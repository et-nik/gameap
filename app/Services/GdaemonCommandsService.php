<?php

namespace Gameap\Services;

use Gameap\Models\DedicatedServer;
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
     * @param int
     */
    protected function configureGdaemon($dsId)
    {
        $dedicatedServer = DedicatedServer::findOrFail($dsId);

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