<?php

namespace Tests\Feature\Validation\Controllers;

use Bouncer;
use Gameap\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class ModulesControllerTest extends TestCase
{
    /** @var User */
    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
        $this->be($this->user);
        Bouncer::sync($this->user)->roles(['admin']);
    }

    public function invalidDataProvider(): array
    {
        return [
            ['invalid@name', '1.0', 'module'],
            ['valid-name', 'invalid@version', 'version'],
        ];
    }

    /**
     * @dataProvider invalidDataProvider
     */
    public function testInstallInvalid(string $name, string $version, string $expectedErrorIn): void
    {
        $response = $this->post(route('modules.install'), [
            '_token' => Session::token(),
            'module' => $name,
            'version' => $version,
        ]);

        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertSessionHasErrors($expectedErrorIn);
    }
}
