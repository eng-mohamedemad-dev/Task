<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function __construct(private UserRepository $repo) {}

    public function register(array $data)
    {
        $data['role'] = $data['role'] ?? 'customer';
        $user = $this->repo->create($data);
        return $this->map($user);
    }

    public function login(array $credentials)
    {
        $user = $this->repo->findByEmail($credentials['email']);

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            return null;
        }

        return $this->map($user);
    }

    protected function map($user) {
        $token = $user->createToken("auth_token")->plainTextToken;
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'token' => $token
        ];
    }
}
