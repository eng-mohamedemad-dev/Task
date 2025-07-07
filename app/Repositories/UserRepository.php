<?php

namespace App\Repositories;

use App\Models\User;
use App\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function create(array $data): User
    {
        $data['password'] = bcrypt($data['password']);
        return User::create($data);
    }

    public function findByEmail(string $email): ?User
    {
        return User::firstWhere('email', $email);
    }
}
