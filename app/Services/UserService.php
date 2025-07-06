<?php

namespace App\Services;

use Illuminate\Support\Facades\Hash;
use App\Interfaces\UserRepositoryInterface;

class UserService
{
    public function __construct(protected UserRepositoryInterface $userRepository) {
    }

    public function register(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        $user = $this->userRepository->create($data);
        return $user ? true : false;
    }

    public function login(string $email, string $password)
    {
        $user = $this->userRepository->findByEmail($email);
        if ($user && Hash::check($password, $user->password)) {
            return $this->map($user);
        }
    }

    private function map($user)
    {
        $token = $user->createToken('api_token')->plainTextToken;
        return [
            'name' => $user->name,
            'email' => $user->email,
            'token' => $token,
        ];
    }
}
