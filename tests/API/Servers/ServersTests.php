<?php

namespace Tests\API\Servers;

use Gameap\Models\Server;
use Gameap\Models\User;
use Gameap\Repositories\UserRepository;
use Illuminate\Http\Response;
use PHPUnit\Framework\Assert;
use Silber\Bouncer\Bouncer;
use Tests\API\APITestCase;

class ServersTests extends APITestCase
{
    /** @var \Silber\Bouncer\Bouncer */
    protected $bouncer;

    /** @var UserRepository */
    private $userRepository;

    public function setUp(): void
    {
        parent::setUp();

        $this->bouncer = $this->app->get(Bouncer::class);
        $this->bouncer->dontCache();

        $this->userRepository = $this->app->get(UserRepository::class);
    }

    public function testListAdmin_Success()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $this->bouncer->sync($user)->roles(['admin']);
        $node = $this->givenNode();
        $gameMod = $this->givenGameMod();
        $server = factory(Server::class)->create([
            'ds_id' => $node->id,
            'game_mod_id' => $gameMod->id,
            'game_id' => $gameMod->game_code,
        ]);

        $response = $this->get('/api/servers', [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(Response::HTTP_OK);
        $ids = $response->json('*.id');
        Assert::assertContains($server->id, $ids);
        $uuids = $response->json('*.uuid');
        Assert::assertContains($server->uuid, $uuids);
    }

    public function testListUser_Success()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $node = $this->givenNode();
        $gameMod = $this->givenGameMod();
        $server1 = factory(Server::class)->create([
            'ds_id' => $node->id,
            'game_mod_id' => $gameMod->id,
            'game_id' => $gameMod->game_code,
        ]);
        $this->userRepository->updateServerPermission($user, $server1, []);
        $server2 = factory(Server::class)->create([
            'ds_id' => $node->id,
            'game_mod_id' => $gameMod->id,
            'game_id' => $gameMod->game_code,
        ]);

        $response = $this->get('/api/servers', [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(Response::HTTP_OK);
        $ids = $response->json('*.id');
        $uuids = $response->json('*.uuid');
        Assert::assertContains($server1->id, $ids);
        Assert::assertContains($server1->uuid, $uuids);
        Assert::assertNotContains($server2->id, $ids);
        Assert::assertNotContains($server2->uuid, $uuids);
    }
}
