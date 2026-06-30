<?php

namespace App\Dtos\Auth;

class RegisterDto
{
    public function __construct(
        public readonly string $email,
        public readonly string $password,
        public readonly string $name
    ) {}

    /**
     * @param array $data
     * @return self
     */
    public static function apply(array $data): self
    {
        return new self(
            email: $data['email'],
            password: $data['password'],
            name: $data['name']
        );
    }
}
