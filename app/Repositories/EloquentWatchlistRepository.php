<?php

namespace App\Repositories;

use App\Dtos\PageDto;
use App\Dtos\Watchlist\UpdateWatchlistDto;
use App\Dtos\Watchlist\WatchlistDto;
use App\Dtos\Watchlist\WatchlistFilterDto;
use App\Models\Watchlist\Watchlist;
use App\Repositories\Contracts\WatchlistRepository;
use App\Repositories\Filters\SearchFilter;
use App\Repositories\Filters\StatusFilter;
use App\Repositories\Filters\UserFilter;
use Illuminate\Pagination\LengthAwarePaginator;

class EloquentWatchlistRepository implements WatchlistRepository
{

    /**
     * @param WatchlistDto $dto
     * @return Watchlist
     */
    public function create(WatchlistDto $dto): Watchlist
    {
        return Watchlist::create([
            'user_id' => $dto->userId,
            'movie_id' => $dto->movieId,
            'title' => $dto->title,
            'imdb_id' => $dto->imdbId,
            'status' => $dto->status ?? null,
            'notes' => $dto->notes ?? null
        ]);
    }

    /**
     * @param string $imdbId
     * @return Watchlist|null
     */
    public function findByImdbId(string $imdbId): Watchlist|null
    {
        return Watchlist::where('imdb_id', $imdbId)
            ->first();
    }

    /**
     * @param int $id
     * @return Watchlist|null
     */
    public function findById(int $id): Watchlist|null
    {
        return Watchlist::where('id', $id)
            ->first();
    }

    /**
     * @param PageDto $pageDto
     * @param WatchlistFilterDto $filter
     * @return LengthAwarePaginator
     */
    public function getWatchlist(PageDto $pageDto, WatchlistFilterDto $filter): LengthAwarePaginator
    {
        $watchlist = Watchlist::query()
            ->tap(new UserFilter($filter->userId))
            ->tap(new StatusFilter($filter->status))
            ->tap(new SearchFilter($filter->search))
            ->paginate(
                perPage: $pageDto->perPage,
                columns: $pageDto->columns,
                pageName: $pageDto->pageName,
                page: $pageDto->page
            );;

        return $watchlist;
    }

    /**
     * Remove watchlist entry
     * @param int $id
     * @return void
     */
    public function remove(int $id): void
    {
        Watchlist::where('id', $id)
            ->delete();
    }

    /**
     * @param Watchlist $watchlist
     * @param UpdateWatchlistDto $dto
     * @return Watchlist
     */
    public function update(Watchlist $watchlist, UpdateWatchlistDto $dto): Watchlist
    {
        if ($dto->title) {
            $watchlist->title = $dto->title;
        }

        if ($dto->notes) {
            $watchlist->notes = $dto->notes;
        }

        if ($dto->status) {
            $watchlist->status = $dto->status;
        }

        $watchlist->update();

        return $watchlist;
    }
}
