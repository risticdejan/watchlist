<?php

namespace App\Repositories\Contracts\Movies;

use App\Dtos\Movies\MovieDto;
use App\Models\Movies\Movie;

interface MovieRepository
{
    public function create(MovieDto $dto): Movie;

    public function findByImdbId(string $imdbId): Movie | null;

    public function actorsSync(MovieDto $dto, Movie $movie): void;

    public function writersSync(MovieDto $dto, Movie $movie): void;

    public function genresSync(MovieDto $dto, Movie $movie): void;
}
