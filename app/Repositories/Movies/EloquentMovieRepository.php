<?php

namespace App\Repositories\Movies;

use App\Dtos\Movies\MovieDto;
use App\Models\Movies\Movie;
use App\Repositories\Contracts\Movies\ActorRepository;
use App\Repositories\Contracts\Movies\GenreRepository;
use App\Repositories\Contracts\Movies\MovieRepository;
use App\Repositories\Contracts\Movies\WriterRepository;

class EloquentMovieRepository implements MovieRepository
{
    public function __construct(
        private ActorRepository $actorRepo,
        private GenreRepository $genreRepo,
        private WriterRepository $writerRepo,
    ) {}

    /**
     * @param MovieDto $dto
     * @return Movie
     */
    public function create(MovieDto $dto): Movie
    {
        $movie = Movie::create([
            'title' => $dto->title,
            'imdb_id' => $dto->imdbId,
            'year' => $dto->year,
            'runtime' => $dto->runtime,
            'plot' => $dto->plot,
            'poster' => $dto->poster,
            'language' => $dto->languages,
            'country' => $dto->countries,
            'imdb_rating' => $dto->imdbRating,
            'type' => $dto->type,
        ]);

        return $movie;
    }

    /**
     * @param MovieDto $dto
     * @param Movie $movie
     * @return void
     */
    public function actorsSync(MovieDto $dto, Movie $movie): void
    {
        $actorIDs = [];

        foreach ($dto->actors as $actorDto) {
            $actor = $this->actorRepo->findOrCreate($actorDto);
            if ($actor) {
                $actorIDs[] = $actor->id;
            }
        }

        $movie->actors()->sync(ids: $actorIDs);
    }

    /**
     * @param MovieDto $dto
     * @param Movie $movie
     * @return void
     */
    public function writersSync(MovieDto $dto, Movie $movie): void
    {
        $writerIDs = [];

        foreach ($dto->writers as $writerDto) {
            $writer = $this->writerRepo->findOrCreate($writerDto);
            if ($writer) {
                $writerIDs[] = $writer->id;
            }
        }

        $movie->writers()->sync(ids: $writerIDs);
    }

    /**
     * @param MovieDto $dto
     * @param Movie $movie
     * @return void
     */
    public function genresSync(MovieDto $dto, Movie $movie): void
    {
        $genreIDs = [];

        foreach ($dto->genres as $genreDto) {
            $genre = $this->genreRepo->findOrCreate($genreDto);
            if ($genre) {
                $genreIDs[] = $genre->id;
            }
        }

        $movie->genres()->sync(ids: $genreIDs);
    }

    /**
     * Find a movie by its IMDB id and load relations.
     *
     * @param string $imdbId
     * @return Movie|null
     */
    public function findByImdbId(string $imdbId): Movie|null
    {
        return Movie::query()
            ->with([
                'actors',
                'genres',
                'writers'
            ])
            ->where('imdb_id', $imdbId)
            ->first();
    }
}
