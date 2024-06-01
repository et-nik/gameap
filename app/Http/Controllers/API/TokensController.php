<?php

namespace Gameap\Http\Controllers\API;

use Gameap\Http\Controllers\AuthController;
use Gameap\Http\Requests\API\GeneratePersonalAccessTokenRequest;
use Gameap\Models\User;
use Gameap\Services\PersonalAccessTokenService;
use Illuminate\Contracts\Auth\Factory as AuthFactory;
use Illuminate\Support\Facades\Auth;

class TokensController extends AuthController
{
    /** @var PersonalAccessTokenService */
    private $personalAccessTokenService;

    /** @var AuthFactory */
    protected $authFactory;

    public function __construct(
        PersonalAccessTokenService $personalAccessTokenService,
        AuthFactory $auth
    )
    {
        parent::__construct();

        $this->personalAccessTokenService = $personalAccessTokenService;
        $this->authFactory = $auth;
    }

    public function list()
    {
        /** @var User $currentUser */
        $currentUser = $this->authFactory->guard()->user();

        return response()->json(collect($currentUser->tokens)->map(function ($token) {
            return [
                'id' => $token->id,
                'name' => $token->name,
                'abilities' => $token->abilities,
                'last_used_at' => $token->last_used_at,
                'created_at' => $token->created_at,
            ];
        }));
    }

    public function abilities()
    {
        /** @var User $currentUser */
        $currentUser = $this->authFactory->guard()->user();
        $tokenAbilities = $this->personalAccessTokenService->getGrouppedAbilitiesDescriptions($currentUser);

        return response()->json($tokenAbilities);
    }

    public function store(GeneratePersonalAccessTokenRequest $request)
    {
        /** @var User $currentUser */
        $currentUser = $this->authFactory->guard()->user();
        $token = $currentUser->createToken($request->token_name, $request->abilities);

        return response()->json([
            'token' => $token->plainTextToken,
        ]);
    }

    public function destroy($tokenId)
    {
        /** @var User $currentUser */
        $currentUser = $this->authFactory->guard()->user();
        $currentUser->tokens()->where('id', $tokenId)->delete();

        return response()->json([
            'message' => 'Token deleted',
        ]);
    }
}