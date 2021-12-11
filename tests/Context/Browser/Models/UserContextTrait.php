<?php

namespace Tests\Context\Browser\Models;

use Gameap\Models\User;

trait UserContextTrait
{
    public function givenUser(): User
    {
        return factory(User::class)->create();
    }
}
