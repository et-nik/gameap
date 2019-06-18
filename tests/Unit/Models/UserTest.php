<?php


namespace Tests\Unit\Models;

use Gameap\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function testSetPassword()
    {
        factory(User::class, 1)->create();

        $user = User::where(['id' => 1])->first();
        $oldPassword = $user->password;
        $user->password = 'new_pass';

        $this->assertNotEquals($oldPassword, $user->password);
        $this->assertNotEquals('new_pass', $user->password);
    }
}