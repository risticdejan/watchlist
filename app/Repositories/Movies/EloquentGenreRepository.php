<?php

namespace App\Repositories\Movies;

use App\Dtos\Movies\GenreDto;
use App\Models\Movies\Genre;
use App\Repositories\Contracts\Movies\GenreRepository;

class EloquentGenreRepository implements GenreRepository
{
    /**
     * @param GenreDto $dto
     * @return Genre
     */
    public function create(GenreDto $dto): Genre
    {
        return Genre::create(['name' => $dto->name]);
    }

    /**
     * @param string $name
     * @return Genre | null
     */
    public function findByName(string $name): Genre | null
    {
        return Genre::query()->where('name', $name)->first();
    }

    /**
     * @param GenreDto $dto
     * @return Genre
     */
    public function findOrCreate(GenreDto $dto): Genre
    {
        return Genre::firstOrCreate(['name' => $dto->name]);
    }
}
