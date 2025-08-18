<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Requests\RegisterRequest;

class AuthController extends Controller
{
    public function __construct(private UserService $authService) {}

    public function register(RegisterRequest $request)
    {
        $result = $this->authService->register($request->validated());
    
        return $this->successResponse('User registered successfully', $result);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $result = $this->authService->login($credentials);

        if (! $result) {
            return $this->errorResponse('Invalid credentials', 401);
        }

        return $this->successResponse('Login successful', $result);
    }

    public function logout(Request $request)
{
    $request->user()->currentAccessToken()->delete();

    return $this->successResponse('Logged out successfully');
}

}
