<?php

namespace App\Services;

use App\Dtos\Auth\LoginDto;
use App\Dtos\Auth\RegisterDto;
use App\Models\User;
use App\Repositories\Contracts\UserRepository;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function __construct(
        private UserRepository $userRepo
    ) {}

    /**
     * @param RegisterDto $dto
     * @return string
     */
    public function registerUser(RegisterDto $dto): string
    {
        $user = $this->userRepo->create($dto);

        $token = $user->createToken('auth-token')->plainTextToken;

        return $token;
    }

    /**
     * @param LoginDto $dto
     * @return string|null
     */
    public function login(LoginDto $dto): string | null
    {
        $user = $this->userRepo->findByEmail($dto->email);

        if (!$user || !Hash::check($dto->password, $user->password)) {
            return null;
        }

        $token = $user->createToken('auth-token')->plainTextToken;

        return $token;
    }

    /**
     * @param User $user
     * @return void
     */
    public function logout(User $user)
    {
        /** @var \Laravel\Sanctum\PersonalAccessToken|null $token */
        $token = $user->currentAccessToken();

        $token->delete();
    }
}
