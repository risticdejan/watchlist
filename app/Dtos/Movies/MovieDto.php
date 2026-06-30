<?php

namespace App\Dtos\Movies;

class MovieDto
{
    /**
     * @param GenreDto[] $genres
     * @param WriterDto[] $writers
     * @param ActorDto[] $actors
     */
    public function __construct(
        public string $imdbId,
        public string $title,
        public ?int $year,
        public ?string $rated,
        public ?string $released,
        public ?int $runtime,
        public ?string $director,
        public ?string $plot,
        public array $genres,
        public array $writers,
        public array $actors,
        public string $languages,
        public string $countries,
        public ?string $awards,
        public ?string $poster,
        public ?float $imdbRating,
        public ?int $imdbVotes,
        public ?string $type
    ) {}

    public static function apply(array $data): self
    {
        return new self(
            imdbId: $data['imdbID'],
            title: $data['Title'],
            year: self::year($data['Year']),
            rated: self::nullable($data['Rated']),
            released: self::nullable($data['Released']),
            runtime: self::runtime($data['Runtime']),
            director: self::nullable($data['Director']),
            plot: self::nullable($data['Plot']),
            genres: self::genres($data['Genre']),
            writers: self::writers($data['Writer']),
            actors: self::actors($data['Actors']),
            languages: self::nullable($data['Language']),
            countries: self::nullable($data['Country']),
            awards: self::nullable($data['Awards']),
            poster: self::nullable($data['Poster']),
            imdbRating: self::imdbRating($data['imdbRating']),
            imdbVotes: self::votes($data['imdbVotes']),
            type: self::nullable($data['Type'])
        );
    }

    /**
     * @return GenreDto[]
     */
    private static function genres(string $genres): array
    {
        return array_map(
            fn(string $genre) => new GenreDto(trim($genre)),
            self::explode($genres)
        );
    }

    /**
     * @return WriterDto[]
     */
    private static function writers(string $writers): array
    {
        return array_map(
            fn(string $writer) => new WriterDto(trim($writer)),
            self::explode($writers)
        );
    }

    /**
     * @return ActorDto[]
     */
    private static function actors(string $actors): array
    {
        return array_map(
            fn(string $actor) => new ActorDto(trim($actor)),
            self::explode($actors)
        );
    }


    private static function explode(string $value): array
    {
        if ($value === 'N/A') {
            return [];
        }

        return explode(',', $value);
    }

    private static function nullable(?string $value): ?string
    {
        return $value === 'N/A'
            ? null
            : $value;
    }

    private static function runtime(?string $value): ?int
    {
        if ($value === null || $value === 'N/A') {
            return null;
        }

        return (int) filter_var($value, FILTER_SANITIZE_NUMBER_INT);
    }

    private static function year(?string $value): ?int
    {
        return is_numeric($value)
            ? (int) $value
            : null;
    }

    private static function imdbRating(?string $value): ?float
    {
        return is_numeric($value)
            ? (float) $value
            : null;
    }

    private static function votes(?string $value): ?int
    {
        if ($value === null || $value === 'N/A') {
            return null;
        }

        return (int) str_replace(',', '', $value);
    }
}
