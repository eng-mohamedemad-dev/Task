<?php

namespace App\Repositories;

use App\Models\User;
use App\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function findByEmail(string $email)
    {
        return User::firstWhere('email', $email);
    }

    public function create(array $data)
    {
        return User::create($data);
    }
}
