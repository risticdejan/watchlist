<?php

namespace App\Dtos\Watchlist;

use App\Enums\Status;

class UpdateWatchlistDto
{
    public function __construct(
        public readonly ?string $title = null,
        public readonly ?Status $status = null,
        public readonly ?string $notes = null,
    ) {}

    /**
     * Create WatchlistDto from array data
     */
    public static function apply(array $data): self
    {
        return new self(
            title: $data['title'],
            status: $data['status'] ? $data['status'] : null,
            notes: $data['notes']
        );
    }
}
