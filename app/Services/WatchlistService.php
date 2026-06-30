<?php

namespace App\Services;

use App\Dtos\Movies\MovieDto;
use App\Dtos\PageDto;
use App\Dtos\Watchlist\UpdateWatchlistDto;
use App\Dtos\Watchlist\WatchlistDto;
use App\Dtos\Watchlist\WatchlistFilterDto;
use App\Models\User;
use App\Models\Watchlist\Watchlist;
use App\Repositories\Contracts\WatchlistRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class WatchlistService
{
    public function __construct(
        private MovieService $movieService,
        private OmdbService $omdbService,
        private WatchlistRepository $watchlistRepo,
    ) {}

    /**
     * Add movie into user's watchlist
     *
     * @param User $user
     * @param string $imdbId
     * @param string|null $notes
     * @return bool
     */
    public function addMovieIntoList(User $user, string $imdbId, ?string $notes): bool
    {
        // Check if movie exists in database
        $movie = $this->movieService->getByImdbId($imdbId);

        if (!$movie) {
            $data = $this->omdbService->fetchMovieByImdbId($imdbId);

            if (!$data) {
                return false;
            }

            $movieDto = MovieDto::apply($data);
            $movie = $this->movieService->store($movieDto);

            if (!$movie) {
                return false;
            }
        }

        $dto = WatchlistDto::apply([
            'userId' => $user->id,
            'movieId' => $movie->id,
            'title' => $movie->title,
            'imdbId' => $imdbId,
            null,
            'notes' => $notes ?? null
        ]);

        $watchlist = $this->watchlistRepo->create($dto);

        return true;
    }

    /**
     * Get user's watchlist
     *
     * @param PageDto $pageDto
     * @param WatchlistFilterDto $filter
     * @return LengthAwarePaginator
     */
    public function getWatchlist(PageDto $pageDto, WatchlistFilterDto $filter): LengthAwarePaginator
    {
        $watchlists = $this->watchlistRepo->getWatchlist($pageDto, $filter);

        return $watchlists;
    }

    /**
     * Remove movie from user's watchlist
     *
     * @param int $id
     * @return void
     */
    public function removeFromWatchlist(int $id): void
    {
        $this->watchlistRepo->remove($id);
    }

    /**
     * Find watchlist entry by IMDb ID
     *
     * @param string $imdbID
     * @return Watchlist | null
     */
    public function findByImdbId(string $imdbID): Watchlist | null
    {
        return $this->watchlistRepo->findByImdbId($imdbID);
    }

    /**
     * Find watchlist entry by ID
     *
     * @param int $id
     * @return Watchlist | null
     */
    public function findById(int $id): Watchlist | null
    {
        return $this->watchlistRepo->findById($id);
    }

    /**
     * Update watchlist entry
     *
     * @param Watchlist $watchlist
     * @param UpdateWatchlistDto $dto
     * @return Watchlist
     */
    public function update(Watchlist $watchlist, UpdateWatchlistDto $dto): Watchlist
    {
        return $this->watchlistRepo->update($watchlist, $dto);
    }
}
