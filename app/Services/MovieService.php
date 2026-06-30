<?php

namespace App\Services;

use App\Dtos\Movies\MovieDto;
use App\Models\Movies\Movie;
use App\Repositories\Contracts\Movies\MovieRepository;

class MovieService
{
    public function __construct(
        private MovieRepository $movieRepo
    ) {}

    /**
     * @param MovieDto $dto
     * @return Movie
     */
    public function store(MovieDto $dto): Movie
    {
        $movie = $this->movieRepo->create($dto);
        if (!empty($dto->actors)) {
            $this->movieRepo->actorsSync($dto, $movie);
        }

        if (!empty($dto->genres)) {
            $this->movieRepo->genresSync($dto, $movie);
        }

        if (!empty($dto->writers)) {
            $this->movieRepo->writersSync($dto, $movie);
        }

        return $movie;
    }

    /**
     * @param string $imdbId
     * @return Movie|null
     */
    public function getByImdbId(string $imdbId): Movie | null
    {
        return $this->movieRepo->findByImdbId($imdbId);
    }
}
