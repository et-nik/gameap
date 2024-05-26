<?php

namespace Tests\Feature\Permissions;

use Gameap\Models\User;
use Gameap\Repositories\UserRepository;
use Silber\Bouncer\Bouncer;
use Tests\TestCase;

abstract class PermissionsTestCase extends TestCase
{
    /**
     * @var User
     */
    protected $user;

    /** @var UserRepository */
    protected $userRepository;

    /** @var Bouncer */
    protected $bouncer;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
        $this->be($this->user);

        $this->bouncer = $this->app->get(Bouncer::class);

        $this->userRepository = new UserRepository($this->bouncer);
    }

    public function setCurrentUserRoles($roles = [])
    {
        $this->bouncer->sync($this->user)->roles($roles);
        $this->bouncer->refresh();
    }
}