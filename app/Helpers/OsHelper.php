<?php

namespace Gameap\Helpers;

class OsHelper
{
    public static function tempFile(): string
    {
        return tempnam(self::tempDirectory(), self::randomFileName());
    }

    public static function tempDirectory(): string
    {
        return sys_get_temp_dir();
    }

    public static function makeTempDirectory(): string
    {
        $directory = self::tempDirectory() . "/" . self::randomFileName();
        mkdir($directory);

        return $directory;
    }

    private static function randomFileName(): string
    {
        $bytes = random_bytes(6);
        return bin2hex($bytes);
    }
}
