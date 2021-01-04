<?php

namespace Gameap\Adapters;

use splitbrain\PHPArchive\Tar;

class Archiver
{
    /**
     * @throws \splitbrain\PHPArchive\ArchiveCorruptedException
     * @throws \splitbrain\PHPArchive\ArchiveIOException
     * @throws \splitbrain\PHPArchive\ArchiveIllegalCompressionException
     */
    public function extractTarGzip(string $path, string $destination, int $strip = 0): array
    {
        $tar = new Tar();
        $tar->open($path);
        $contents = $tar->extract($destination, $strip);

        $fileList = [];
        foreach ($contents as $file) {
            $fileList[] = $file->getPath();
        }

        return $fileList;
    }
}
