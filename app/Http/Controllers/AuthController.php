<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;

class AuthController extends Controller
{
    public function __construct(protected UserService $userService)
    {
    }

    public function register(RegisterRequest $request)
    {
        $user = $this->userService->register($request->validated());
        return $user ? $this->successResponse('Registration successful, please login', '',201) :
        $this->errorResponse('Registration failed', 400);
    }

    public function login(LoginRequest $request)
    {
        $data = $request->validated();
        $user = $this->userService->login($data['email'], $data['password']);
        return $user ? $this->successResponse('Login successful', $user) :
        $this->errorResponse('Invalid login credentials', 401);
    }

    public function logout(Request $request )
    {
        $user = $request->user();
        $user->currentAccessToken()->delete();
        return $this->successResponse('Logout successful');
    }
}
