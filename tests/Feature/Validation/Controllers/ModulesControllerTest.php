<?php

namespace Tests\Feature\Validation\Controllers;

use Silber\Bouncer\Bouncer;
use Gameap\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class ModulesControllerTest extends TestCase
{
    /** @var Bouncer */
    protected $bouncer;

    public function setUp(): void
    {
        parent::setUp();

        $this->bouncer = $this->app->get(Bouncer::class);
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
        $user = factory(User::class)->create();
        $this->be($user);
        $this->bouncer->sync($user)->roles(['admin']);

        $response = $this->post(route('modules.install'), [
            '_token' => Session::token(),
            'module' => $name,
            'version' => $version,
        ]);

        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertSessionHasErrors($expectedErrorIn);
    }
}
