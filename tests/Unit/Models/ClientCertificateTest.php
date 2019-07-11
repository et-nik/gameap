<?php
/**
 * Created by PhpStorm.
 * User: nikita
 * Date: 18.06.19
 * Time: 17:27
 */

namespace Tests\Unit\Models;

use Gameap\Models\DedicatedServer;
use Gameap\Models\ClientCertificate;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;

class ClientCertificateTest extends TestCase
{
    public function testDedicatedServers()
    {
        $clientCertificate = ClientCertificate::first();
        $this->assertInstanceOf(Collection::class, $clientCertificate->dedicatedServers);
    }
}