<?php


namespace Tests\Feature\Validation\Controllers;

use Silber\Bouncer\Bouncer;
use Gameap\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class TokensControllerTest extends TestCase
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
            ['Token Name', ['Inva1iD%'], 'abilities.*'],
            ['Token Name', [], 'abilities'],
            ['', ['ability'], 'token_name'],
        ];
    }

    /**
     * @dataProvider invalidDataProvider
     */
    public function testInvalidRequestAttributes(string $tokenName, array $abilities, string $expectedErrorIn): void
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $this->bouncer->sync($user)->roles(['admin']);

        $response = $this->post(route('tokens.create'), [
            '_token' => Session::token(),
            'token_name' => $tokenName,
            'abilities'  => $abilities,
        ]);

        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertSessionHasErrors($expectedErrorIn);
    }
}
