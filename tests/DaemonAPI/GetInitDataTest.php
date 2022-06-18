<?php

namespace Tests\DaemonAPI;

use Symfony\Component\HttpFoundation\Response;

class GetInitDataTest extends TestCase
{
    public function testGetInitData_Success()
    {
        $node = $this->givenNode();

        $response = $this->get(
            '/gdaemon_api/dedicated_servers/get_init_data/' . $node->id,
            [
                'X-Auth-Token' => $node->gdaemon_api_token,
                'Accept' => 'application/json',
            ]
        );

        $response->assertStatus(Response::HTTP_OK);
        $this->assertEquals($node->work_path, $response->json('work_path'));
        $this->assertEquals($node->steamcmd_path, $response->json('steamcmd_path'));
        $this->assertEquals($node->prefer_install_method, $response->json('prefer_install_method'));
        $this->assertEquals($node->script_install, $response->json('script_install'));
        $this->assertEquals($node->script_reinstall, $response->json('script_reinstall'));
        $this->assertEquals($node->script_update, $response->json('script_update'));
        $this->assertEquals($node->script_start, $response->json('script_start'));
        $this->assertEquals($node->script_pause, $response->json('script_pause'));
        $this->assertEquals($node->script_unpause, $response->json('script_unpause'));
        $this->assertEquals($node->script_stop, $response->json('script_stop'));
        $this->assertEquals($node->script_kill, $response->json('script_kill'));
        $this->assertEquals($node->script_restart, $response->json('script_restart'));
        $this->assertEquals($node->script_status, $response->json('script_status'));
        $this->assertEquals($node->script_get_console, $response->json('script_get_console'));
        $this->assertEquals($node->script_send_command, $response->json('script_send_command'));
        $this->assertEquals($node->script_delete, $response->json('script_delete'));
    }

    public function testGetInitData_InvalidToken()
    {
        $node = $this->givenNode();

        $response = $this->get(
            '/gdaemon_api/dedicated_servers/get_init_data/' . $node->id,
            [
                'X-Auth-Token' => 'invalid',
                'Accept' => 'application/json',
            ]
        );

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
        $response->assertJsonPath('message', 'Invalid api token');
    }
}
