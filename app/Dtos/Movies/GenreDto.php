<?php

namespace App\Dtos\Movies;

class GenreDto
{
    public function __construct(
        public readonly string $name,
    ) {}
}
