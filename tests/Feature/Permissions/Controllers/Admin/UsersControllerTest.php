<?php

namespace Tests\Feature\Permissions\Controllers\Admin;

use Bouncer;
use Faker\Factory;
use Gameap\Models\User;
use Illuminate\Http\Response;
use Tests\TestCase;

class UsersControllerTest extends TestCase
{
    /**
     * @var User
     */
    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
        $this->be($this->user);
    }

    /**
     * @throws \Exception
     */
    public function testAllow()
    {
        Bouncer::sync($this->user)->roles(['admin']);

        // Index
        $response = $this->get(route('admin.users.index'));
        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('admin.users.list');

        // Create
        $response = $this->get(route('admin.users.create'));
        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('admin.users.create');

        $user = factory(User::class)->create();

        // Store
        $faker = Factory::create();
        $response = $this->post(route('admin.users.store'), [
            'login'     => 'secure_test_login_' . random_int(1, 9999),
            'email'     => $faker->email,
            'password'  => $faker->password,
            'name'      => 'SecureTestLogin',
        ]);
        $response->assertStatus(Response::HTTP_FOUND);

        // Edit
        $response = $this->get(route('admin.users.edit', $user->id));
        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('admin.users.edit');

        // Update
        $response = $this->put(route('admin.users.update', $user->id), [
            'name' => 'TestName'
        ]);
        $response->assertStatus(Response::HTTP_FOUND);

        // Destroy
        $response = $this->delete(route('admin.users.destroy', $user->id));
        $response->assertStatus(Response::HTTP_FOUND);
    }

    /**
     * @throws \Exception
     */
    public function testForbidden()
    {
        Bouncer::sync($this->user)->roles(['admin']);
        Bouncer::sync($this->user)->forbiddenAbilities(['admin roles & permissions']);

        // Index
        $response = $this->get(route('admin.users.index'));
        $response->assertStatus(Response::HTTP_FORBIDDEN);

        // Create
        $response = $this->get(route('admin.users.create'));
        $response->assertStatus(Response::HTTP_FORBIDDEN);

        $user = factory(User::class)->create();

        // Store
        $faker = Factory::create();
        $response = $this->post(route('admin.users.store'), [
            'login'     => 'secure_test_login_' . random_int(1, 9999),
            'email'     => $faker->email,
            'password'  => $faker->password,
            'name'      => 'SecureTestLogin',
        ]);
        $response->assertStatus(Response::HTTP_FORBIDDEN);

        // Edit
        $response = $this->get(route('admin.users.edit', $user->id));
        $response->assertStatus(Response::HTTP_FORBIDDEN);

        // Update
        $response = $this->put(route('admin.users.update', $user->id), [
            'name' => 'TestName'
        ]);
        $response->assertStatus(Response::HTTP_FORBIDDEN);

        // Destroy
        $response = $this->delete(route('admin.users.destroy', $user->id));
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * @throws \Exception
     */
    public function testForbiddenUser()
    {
        Bouncer::sync($this->user)->roles(['user']);

        // Index
        $response = $this->get(route('admin.users.index'));
        $response->assertStatus(Response::HTTP_FORBIDDEN);

        // Create
        $response = $this->get(route('admin.users.create'));
        $response->assertStatus(Response::HTTP_FORBIDDEN);

        $user = factory(User::class)->create();

        // Store
        $faker = Factory::create();
        $response = $this->post(route('admin.users.store'), [
            'login'     => 'secure_test_login_' . random_int(1, 9999),
            'email'     => $faker->email,
            'password'  => $faker->password,
            'name'      => 'SecureTestLogin',
        ]);
        $response->assertStatus(Response::HTTP_FORBIDDEN);

        // Edit
        $response = $this->get(route('admin.users.edit', $user->id));
        $response->assertStatus(Response::HTTP_FORBIDDEN);

        // Update
        $response = $this->put(route('admin.users.update', $user->id), [
            'name' => 'TestName'
        ]);
        $response->assertStatus(Response::HTTP_FORBIDDEN);

        // Destroy
        $response = $this->delete(route('admin.users.destroy', $user->id));
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
}