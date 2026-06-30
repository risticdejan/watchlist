<?php

namespace App\Repositories\Contracts;

use App\Dtos\PageDto;
use App\Dtos\Watchlist\UpdateWatchlistDto;
use App\Dtos\Watchlist\WatchlistDto;
use App\Dtos\Watchlist\WatchlistFilterDto;
use App\Models\Watchlist\Watchlist;
use Illuminate\Pagination\LengthAwarePaginator;

interface WatchlistRepository
{

    public function create(WatchlistDto $dto): Watchlist;

    public function findByImdbId(string $imdbId): Watchlist | null;

    public function findById(int $id): Watchlist | null;

    public function getWatchlist(PageDto $pageDto, WatchlistFilterDto $filter): LengthAwarePaginator;

    public function remove(int $id);

    public function update(Watchlist $watchlist, UpdateWatchlistDto $dto): Watchlist;
}
