<?php

namespace Tests\API\Admin;

use Gameap\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Silber\Bouncer\Bouncer;
use Symfony\Component\HttpFoundation\Response;
use Tests\API\APITestCase;
use Gameap\Models\Game;

class GamesTest extends APITestCase
{
    use WithFaker;

    /** @var Bouncer */
    private $bouncer;

    public function setUp(): void
    {
        parent::setUp();

        $this->bouncer = $this->app->get(Bouncer::class);
        $this->bouncer->dontCache();
    }

    /**
     * Test index method to get list of games.
     *
     * @return void
     */
    public function testIndex_Success()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $this->bouncer->sync($user)->roles(['admin']);
        factory(Game::class)->create([
            'code' => 'test_'.$this->faker->lexify(),
            'name' => $this->faker->unique()->words(3, true),
        ]);

        $response = $this->get('/api/games');

        $response->assertStatus(200)
            ->assertJsonStructure([
                '*' => ['code', 'name', 'engine'],
            ]);
    }

    public function testIndex_AccessDenied()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        factory(Game::class)->create([
            'code' => 'test_'.$this->faker->lexify(),
            'name' => $this->faker->unique()->words(3, true),
        ]);

        $response = $this->get('/api/games');

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * Test store method to create new game.
     *
     * @return void
     */
    public function testStore_Success()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $this->bouncer->sync($user)->roles(['admin']);
        $data = [
            'code' => 'test_'. $this->faker->lexify(),
            'name' => $this->faker->unique()->words(3, true),
            'engine' => $this->faker->unique()->words(3, true),
        ];

        $response = $this->post('/api/games', $data);

        $game = Game::where('code', $data['code'])->firstOrFail();

        $response->assertStatus(201)
            ->assertJsonFragment([
                'code' => $game->code,
                'name' => $game->name,
                'engine' => $game->engine,
            ]);
    }

    public function testStore_AccessDenied()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $data = [
            'code' => 'test_'. $this->faker->lexify(),
            'name' => $this->faker->words(3, true),
            'engine' => $this->faker->word(3, true),
        ];

        $response = $this->post('/api/games', $data);

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * Test show method to get a single game by ID.
     *
     * @return void
     */
    public function testShow_Success()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $this->bouncer->sync($user)->roles(['admin']);
        $game = factory(Game::class)->create([
            'code' => 'test_'. $this->faker->lexify(),
            'name' => $this->faker->unique()->words(3, true),
        ]);

        $response = $this->get('/api/games/' . $game->code);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'code' => $game->code,
                'name' => $game->name,
                'engine' => $game->engine,
            ]);
    }

    public function testShow_AccessDenied()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $game = factory(Game::class)->create([
            'code' => 'test_'. $this->faker->lexify(),
            'name' => $this->faker->unique()->words(3, true),
        ]);

        $response = $this->get('/api/games/' . $game->code);

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * Test update method to update a single game by ID.
     *
     * @return void
     */
    public function testUpdate_Success()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $this->bouncer->sync($user)->roles(['admin']);
        $game = factory(Game::class)->create([
            'code' => 'test_'. $this->faker->lexify(),
            'name' => $this->faker->unique()->words(3, true),
        ]);

        $data = [
            'name' => $this->faker->word(),
            'engine' => $this->faker->word(),
        ];

        $response = $this->put('/api/games/' . $game->code, $data);

        $game = $game->fresh();

        $response->assertStatus(200)
            ->assertJsonFragment([
                'code' => $game->code,
                'name' => $game->name,
                'engine' => $game->engine,
            ]);
    }

    public function testUpdate_AccessDenied()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $game = factory(Game::class)->create([
            'code' => 'test_'. $this->faker->lexify(),
            'name' => $this->faker->unique()->words(3, true),
        ]);
        $data = [
            'name' => $this->faker->word(),
            'engine' => $this->faker->word(),
        ];

        $response = $this->put('/api/games/' . $game->code, $data);

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * Test delete method to delete a single game by ID.
     *
     * @return void
     */
    public function testDelete_Success()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $this->bouncer->sync($user)->roles(['admin']);
        $game = factory(Game::class)->create([
            'code' => 'test_'. $this->faker->lexify(),
            'name' => $this->faker->unique()->words(3, true),
        ]);

        $response = $this->delete('/api/games/' . $game->code);

        $response->assertStatus(204);

        $this->assertNull(Game::find($game->id));
    }

    public function testDelete_AccessDenied()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $game = factory(Game::class)->create([
            'code' => 'test_'. $this->faker->lexify(),
            'name' => $this->faker->unique()->words(3, true),
        ]);

        $response = $this->delete('/api/games/' . $game->code);

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
}
