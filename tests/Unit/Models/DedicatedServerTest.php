<?php
/**
 * Created by PhpStorm.
 * User: nikita
 * Date: 18.06.19
 * Time: 16:56
 */

namespace Tests\Unit\Models;

use Gameap\Models\DedicatedServer;
use Gameap\Models\ClientCertificate;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;

class DedicatedServerTest extends TestCase
{
    public function testServers()
    {
        $ds = DedicatedServer::first();
        $this->assertInstanceOf(Collection::class, $ds->servers);
    }
    
    public function testClientCertificate()
    {
        $ds = DedicatedServer::first();
        $this->assertInstanceOf(ClientCertificate::class, $ds->clientCertificate);
    }
    
    public function testGdaemonSettings()
    {
        $ds = DedicatedServer::first();
        $this->assertIsArray($ds->gdaemonSettings('local'));
    }
    
    public function testIsLinux()
    {
        $ds = DedicatedServer::first();
        
        $linuxDists = ['Linux', 'Debian', 'Ubuntu'];
        
        foreach ($linuxDists as $dist) {
            $ds->os = $dist;
            $this->assertTrue($ds->isLinux());
        }
        
        $ds->os = 'Windows';
        $this->assertFalse($ds->isLinux());
    }
}