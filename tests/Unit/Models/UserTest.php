<?php


namespace Tests\Unit\Models;

use Gameap\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function testSetPasswordAttribute()
    {
        $user = User::where(['id' => 1])->first();
        $oldPassword = $user->password;
        $user->password = 'new_pass';

        $this->assertNotEquals($oldPassword, $user->password);
        $this->assertNotEquals('new_pass', $user->password);
    }
    
    public function testServers()
    {
        $user = User::where(['id' => 1])->first();
        $this->assertInstanceOf(Collection::class, $user->servers);
    }
}
