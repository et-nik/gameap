<?php

namespace Tests\API\FileManager;

use Gameap\Models\User;
use Silber\Bouncer\Bouncer;
use Symfony\Component\HttpFoundation\Response;
use Tests\API\APITestCase;

class InitializeTest extends APITestCase
{
    /** @var Bouncer */
    protected $bouncer;

    public function setUp(): void
    {
        parent::setUp();

        $this->bouncer = $this->app->get(Bouncer::class);
        $this->bouncer->dontCache();
    }

    public function testGuestUser_ExpectUnauthorized()
    {
        $node = $this->givenNode();
        $server = $this->givenGameServer($node->id);

        $response = $this->get(
            sprintf('/file-manager/%d/initialize', $server->id),
            [
                'Accept' => 'application/json',
            ]
        );

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function testAllowed()
    {
        $node = $this->givenNode();
        $server = $this->givenGameServer($node->id);
        $user = factory(User::class)->create();
        $this->be($user);
        $this->bouncer->sync($user)->roles(['admin']);

        $response = $this->get(
            sprintf('/file-manager/%d/initialize', $server->id),
            [
                'Accept' => 'application/json',
            ]
        );

        $response->assertStatus(Response::HTTP_OK);
    }
}
