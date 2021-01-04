<?php

namespace Gameap\Services\Modules;

use Gameap\Adapters\Archiver;
use Gameap\Exceptions\GameapException;
use Illuminate\Support\Facades\Config;

class Installer
{
    private const CONFIG_MODULES_PATH_NAME = 'modules.paths.modules';

    /** @var MarketplaceService */
    private $marketplaceService;

    /** @var Archiver */
    private $archiver;

    public function __construct(MarketplaceService $marketplaceService, Archiver $archiver)
    {
        $this->marketplaceService = $marketplaceService;
        $this->archiver = $archiver;
    }

    /**
     * @throws GameapException
     * @throws \Gameap\Exceptions\InvalidArgumentValueException
     * @throws \splitbrain\PHPArchive\ArchiveCorruptedException
     * @throws \splitbrain\PHPArchive\ArchiveIOException
     * @throws \splitbrain\PHPArchive\ArchiveIllegalCompressionException
     */
    public function install(string $moduleID, string $version = ''): void
    {
        $modulesPath = Config::get(self::CONFIG_MODULES_PATH_NAME);
        $destinationPath = $modulesPath . '/' . ucfirst($moduleID);

        if (!is_writable($modulesPath)) {
            throw new GameapException('No write permissions to modules directory');
        }

        $downloadedFilePath = $this->marketplaceService->downloadModule($moduleID, $version);
        $this->archiver->extractTarGzip($downloadedFilePath, $destinationPath, 1);
    }
}
