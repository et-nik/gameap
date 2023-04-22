<?php

namespace Tests\API\Admin;

use Gameap\Models\User;
use Silber\Bouncer\Bouncer;
use Tests\API\APITestCase;
use Illuminate\Foundation\Testing\WithFaker;

class UsersTest extends APITestCase
{
    use WithFaker;

    public function setUp(): void
    {
        parent::setUp();

        $this->bouncer = $this->app->get(Bouncer::class);
        $this->bouncer->dontCache();
    }

    public function testCreateUser_Success()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $this->bouncer->sync($user)->roles(['admin']);
        $data = [
            'login' => $this->faker->userName(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => bcrypt('password'),
            'name' => $this->faker->name(),
        ];

        $response = $this->post('/api/users', $data);

        $response->assertStatus(201)
            ->assertJson([
                'login' => $data['login'],
                'email' => $data['email'],
                'name' => $data['name'],
            ]);
    }

    public function testGetUser_Success()
    {
        $admin = factory(User::class)->create();
        $this->be($admin);
        $this->bouncer->sync($admin)->roles(['admin']);
        $user = factory(User::class)->create();

        $response = $this->get('/api/users/' . $user->id);

        $response->assertStatus(200)
            ->assertJson($user->toArray());
    }

    public function testUpdateUser_Success()
    {
        $admin = factory(User::class)->create();
        $this->be($admin);
        $this->bouncer->sync($admin)->roles(['admin']);
        $user = factory(User::class)->create();

        $data = [
            'login' => $this->faker->userName,
            'email' => $this->faker->unique()->safeEmail,
            'password' => bcrypt('password'),
            'name' => $this->faker->name,
        ];

        $response = $this->put('/api/users/' . $user->id, $data);

        $response->assertStatus(200)
            ->assertJson([
                'login' => $data['login'],
                'email' => $data['email'],
                'name' => $data['name'],
            ]);
    }

    public function testUpdateUser_AccessDenied()
    {
        $notAdmin = factory(User::class)->create();
        $this->be($notAdmin);
        $user = factory(User::class)->create();

        $data = [
            'login' => $this->faker->userName,
            'email' => $this->faker->unique()->safeEmail,
            'password' => bcrypt('password'),
            'name' => $this->faker->name,
        ];

        $response = $this->put('/api/users/' . $user->id, $data);

        $response->assertStatus(403);
    }

    public function testDeleteUser_Success()
    {
        $admin = factory(User::class)->create();
        $this->be($admin);
        $this->bouncer->sync($admin)->roles(['admin']);
        /* @var User $user */
        $user = factory(User::class)->create();

        $response = $this->delete('/api/users/' . $user->id);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('users', [
            'name'              => $user->name,
            'login'              => $user->login,
        ]);
    }

    public function testListUser_Success()
    {
        $admin = factory(User::class)->create();
        $this->be($admin);
        $this->bouncer->sync($admin)->roles(['admin']);
        factory(User::class)->times(3)->create();

        $response = $this->get('/api/users');

        $users = User::all();
        $response->assertStatus(200)
            ->assertJson($users->toArray());
    }
}
