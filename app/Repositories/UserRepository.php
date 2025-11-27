<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function create(array $data): User
    {
        return User::create($data);
    }

    public function findByPhone(string $phone): ?User
    {
        return User::where('phone', $phone)->first();
    }

    public function findByEmailOrPhone(array $data): ?User
    {
        return User::where('email', $data['email'] ?? null)
                   ->orWhere('phone', $data['phone'] ?? null)
                   ->first();
    }

    public function save(User $user)
    {
        $user->save();
    }
}
