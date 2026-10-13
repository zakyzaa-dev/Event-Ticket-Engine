<?php

namespace App\Services\Implementations;

use App\Exceptions\AuthException;
use App\Models\User;
use App\Services\Interfaces\IAuthService;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;
use Override;

class AuthService implements IAuthService
{
    #[Override]
    public function login(array $creds)
    {
        if (!Auth::attempt($creds)){
            throw new AuthException("Email or password incorrect");
        }

        /** @var User $user */
        $user = Auth::user();
        $token = $user->createToken('token_auth')->plainTextToken;

        return [
            'name' => $user->name,
            'email' => $user->email,
            'token_type' => 'Bearer',
            'token' => $token
        ];
    }

    #[Override]
    public function logout(User $user)
    {
        /** @var PersonalAccessToken $token */
        $token = $user->currentAccessToken();

        if (!$token){
            throw new AuthException("Invalid token or already logout", 401);
        }

        $token->delete();
    }
}
