<?php

namespace App\Dtos\Movies;

class WriterDto
{
    public function __construct(
        public readonly string $name,
    ) {}
}
