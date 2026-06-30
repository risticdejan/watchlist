<?php

namespace App\Dtos\Movies;

class ActorDto
{
    public function __construct(
        public readonly string $name,
    ) {}
}
