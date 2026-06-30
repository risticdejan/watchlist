<?php

namespace App\Dtos\Watchlist;

class WatchlistDto
{
    public function __construct(
        public int $userId,
        public int $movieId,
        public string $imdbId,
        public string $title,
        public string $status = 'to_watch',
        public ?string $notes = null,
    ) {}

    /**
     * Create WatchlistDto from array data
     */
    public static function apply(array $data): self
    {
        return new self(
            userId: $data['userId'],
            movieId: $data['movieId'],
            imdbId: $data['imdbId'],
            title: $data['title'],
            status: $data['status'] ?? 'to_watch',
            notes: $data['notes'] ?? null,
        );
    }
}
