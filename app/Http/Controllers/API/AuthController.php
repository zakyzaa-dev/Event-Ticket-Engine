<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Services\Interfaces\IAuthService;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    protected IAuthService $_authService;
    public function __construct(IAuthService $aser)
    {
        $this->_authService = $aser;
    }

    public function login(LoginRequest $reqlog)
    {
        $login = $this->_authService->login($reqlog->validated());
        return response()->json([
            'message' => 'Login Success',
            'user' => $login,
        ], 200);
    }

    public function logout()
    {
        $this->_authService->logout(Auth::user());
        return response()->json([
            'message' => 'Logout success'
        ], 200);
    }
}
