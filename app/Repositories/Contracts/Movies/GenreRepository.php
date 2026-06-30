<?php

namespace App\Repositories\Contracts\Movies;

use App\Dtos\Movies\GenreDto;
use App\Models\Movies\Genre;

interface GenreRepository
{
    public function create(GenreDto $dto): Genre;

    public function findByName(string $name): Genre | null;

    public function findOrCreate(GenreDto $dto): Genre;
}
