<?php


namespace Tests\Feature\Validation\Controllers;

use Bouncer;
use Gameap\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class TokensControllerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $user = factory(User::class)->create();
        $this->be($user);
        Bouncer::sync($user)->roles(['admin']);
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
        $response = $this->post(route('tokens.create'), [
            '_token' => Session::token(),
            'token_name' => $tokenName,
            'abilities'  => $abilities,
        ]);

        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertSessionHasErrors($expectedErrorIn);
    }
}
