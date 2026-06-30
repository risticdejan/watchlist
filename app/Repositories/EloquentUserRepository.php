<?php

namespace App\Repositories;

use App\Dtos\Auth\RegisterDto;
use App\Models\User;
use App\Repositories\Contracts\UserRepository;

class EloquentUserRepository implements UserRepository
{
    /**
     * Create a new user.
     *
     * @param RegisterDto $dto
     * @return User
     */
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

    /**
     * Find a user by email.
     * @param string $email
     * @return User|null
     */
    public function findByEmail(string $email): User|null
    {
        return User::query()->where('email', $email)->first();
    }
}
