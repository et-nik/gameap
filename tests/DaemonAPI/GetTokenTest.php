<?php

namespace Tests\DaemonAPI;

use Symfony\Component\HttpFoundation\Response;

class GetTokenTest extends TestCase
{
    public function testGetToken_Success()
    {
        $node = $this->givenNode();

        $response = $this->get('/gdaemon_api/get_token', [
            'Authorization' => 'Bearer ' . $node->gdaemon_api_key,
        ]);

        $response->assertStatus(Response::HTTP_OK);
        $this->assertIsString($response->json('token'));
        $this->assertIsInt($response->json('timestamp'));
    }

    public function testGetToken_InvalidToken()
    {
        $this->givenNode();

        $response = $this->get('/gdaemon_api/get_token', [
            'Authorization' => 'Bearer invalid',
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
        $response->assertJsonPath('message', 'Invalid api token');
    }
}
