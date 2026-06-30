<?php

namespace App\Repositories;

use App\Dtos\Auth\RegisterDto;
use App\Models\User;
use App\Repositories\Contracts\UserRepository;

class EloquentUserRepository implements UserRepository
{
    public function create(RegisterDto $dto): User
    {
        return User::create(
            attributes: [
                'name' => $dto->name,
                'email' => $dto->email,
                'password' => $dto->password
            ]
        );
    }

    public function findByEmail(string $email): User | Null
    {
        return User::query()->where('email', $email)->first();
    }
}
