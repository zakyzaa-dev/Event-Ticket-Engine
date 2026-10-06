<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    public function login(LoginRequest $reqlog)
    {
        $creds = $reqlog->validated();

        if (!Auth::attempt($creds)){
            return response()->json([
                'message' => 'Email or password incorrect'
            ], 401);
        }

        /** @var User $user */
        $user = Auth::user();
        $token =  $user->createToken('token_auth')->plainTextToken;

        return response()->json([
            'message' => 'Login Success',
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
                'token_type' => 'Bearer',
                'token' => $token
            ],
        ], 200);
    }

    public function logout()
    {
        /** @var User $user */
        $user = Auth::user();

        /** @var PersonalAccessToken $token */
        $token = $user->currentAccessToken();
        $token->delete();

        return response()->json([
            'message' => 'Logout success'
        ], 200);
    }
}
