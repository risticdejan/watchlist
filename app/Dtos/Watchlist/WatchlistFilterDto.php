<?php

namespace App\Dtos\Watchlist;

use App\Enums\Status;

class WatchlistFilterDto
{
    private function __construct(
        public readonly ?string $search = '',
        public readonly ?int $userId = 0,
        public readonly ?Status $status = null,
    ) {}

    public static function apply(array $data): self
    {
        return new self(
            search: $data['search'],
            userId: $data['userId'],
            status: $data['status']
        );
    }
}
