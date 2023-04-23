<?php

namespace Gameap\Http\Controllers;

use Gameap\Http\Requests\GeneratePersonalAccessTokenRequest;
use Gameap\Models\PersonalAccessToken;
use Gameap\Models\User;
use Gameap\Services\PersonalAccessTokenService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class TokensController extends AuthController
{
    /** @var PersonalAccessTokenService */
    private $personalAccessTokenService;

    public function __construct(PersonalAccessTokenService $personalAccessTokenService)
    {
        parent::__construct();

        $this->personalAccessTokenService = $personalAccessTokenService;
    }

    public function index()
    {
        /** @var User $user */
        $user = Auth::user();

        $tokens = $user->tokens;

        return view('profile.tokens', [
            'tokens' => $tokens,
        ]);
    }

    public function generate()
    {
        /** @var User $user */
        $user = Auth::user();
        $tokenAbilities = $this->personalAccessTokenService->getGrouppedAbilitiesDescriptions($user);

        return view('profile.generate_token', [
            'abilities' => $tokenAbilities,
        ]);
    }

    public function create(GeneratePersonalAccessTokenRequest $request): RedirectResponse
    {
        /** @var User $user */
        $user  = Auth::user();
        $token = $user->createToken($request->token_name, $request->abilities);

        return redirect()->route('tokens')
            ->with('notification', __('tokens.token_created_notification'))
            ->with('token', $token->plainTextToken);
    }

    public function destroy(PersonalAccessToken $token): RedirectResponse
    {
        $token->delete();

        return redirect()->route('tokens')
            ->with('success', __('tokens.token_removed_msg', ['token' => $token->plainTextToken]));
    }
}
