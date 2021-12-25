<?php

namespace Tests\Context\Browser;

use function PHPUnit\Framework\directoryExists;

trait DaemonContextTrait
{
    public static function installGameAPDaemon(): bool
    {
        if (!file_exists("/srv/gameap")) {
            mkdir("/srv/gameap", 0777, true);
        }

        if (!file_exists("/etc/gameap-daemon/certs")) {
            mkdir("/etc/gameap-daemon/certs", 0777, true);
        }

        if (!file_exists("/usr/bin/gameap-daemon")) {
            system("
                cd /tmp \\
                    && curl -qL -o gameap-daemon.tar.gz 'https://packages.gameap.ru/gameap-daemon/download-release?os=linux&arch=amd64' \\
                    && tar -xvf gameap-daemon.tar.gz \\
                    && cp gameap-daemon /usr/bin/gameap-daemon \\
                    && chmod +x /usr/bin/gameap-daemon \\
                    && curl -qL -o initrd-script-debian.tar.gz https://packages.gameap.ru/gameap-daemon/initrd-script-debian.tar.gz \\
                    && tar -xvf initrd-script-debian.tar.gz \\
                    && cp ./default/gameap-daemon /etc/default/gameap-daemon \\
                    && cp ./init.d/gameap-daemon /etc/init.d/gameap-daemon \\
                    && curl -qL -o gameap-daemon.cfg https://raw.githubusercontent.com/gameap/daemon/master/config/gameap-daemon.cfg \\
                    && cp ./gameap-daemon.cfg /etc/gameap-daemon/gameap-daemon.cfg \\
                    && curl -qL -o runner.sh https://raw.githubusercontent.com/gameap/scripts/master/process-manager/screen/runner.sh \\
                    && cp runner.sh /srv/gameap/runner.sh \\
                    && chmod +x /srv/gameap/runner.sh
            ");
        }

        return true;
    }

    public static function restartGameAPDaemon(): void
    {
        system("service gameap-daemon restart");
    }
}
