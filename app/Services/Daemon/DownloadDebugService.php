<?php

namespace Gameap\Services\Daemon;

use Gameap\Helpers\OsHelper;
use Gameap\Models\DedicatedServer;
use Knik\Gameap\GdaemonFiles;
use ZipArchive;

class DownloadDebugService
{
    const LINUX_LOG_PATH = '/var/log/gameap-daemon';
    const WINDOWS_LOG_PATH = 'C:/gameap/daemon/logs';

    /** @var GdaemonFiles */
    private $gdaemonFiles;

    public function __construct(GdaemonFiles $gdaemonFiles)
    {
        $this->gdaemonFiles = $gdaemonFiles;
    }

    public function download(DedicatedServer $dedicatedServer): string
    {
        return $this->downloadFiles($dedicatedServer);
    }

    private function downloadFiles(DedicatedServer $dedicatedServer): string
    {
        $this->gdaemonFiles->setConfig($dedicatedServer->gdaemonSettings());

        if ($dedicatedServer->isLinux()) {
            $logPath = self::LINUX_LOG_PATH;
        } else {
            $logPath = self::WINDOWS_LOG_PATH;
        }

        $tmpDir = OsHelper::makeTempDirectory();

        $zipFilePath = OsHelper::tempFile();
        $zip = new ZipArchive();
        $zip->open($zipFilePath, ZipArchive::CREATE);

        foreach ($this->gdaemonFiles->listFiles($logPath) as $fileName) {
            $fullPath = $logPath . '/' . $fileName;
            $destination = $tmpDir . '/' . $fileName;

            $this->gdaemonFiles->get($fullPath, $destination);

            $zip->addFile($destination, "daemon_logs/". $fileName);
        }

        $zip->close();

        return $zipFilePath;
    }
}
