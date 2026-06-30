<?php

namespace App\Repositories\Contracts;

use App\Dtos\Auth\RegisterDto;
use App\Models\User;

interface UserRepository
{
    public function create(RegisterDto $dto): User;

    public function findByEmail(string $email): User|Null;
}
