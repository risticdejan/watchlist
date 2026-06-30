<?php

namespace App\Http\Controllers\Api;

use App\Dtos\PageDto;
use App\Dtos\Watchlist\UpdateWatchlistDto;
use App\Dtos\Watchlist\WatchlistFilterDto;
use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateWatchlistRequest;
use App\Http\Requests\UpdateWatchlistRequest;
use App\Http\Requests\WatchlistRequest;
use App\Services\WatchlistService;

class WatchlistController extends Controller
{
    public function __construct(
        private WatchlistService $watchlistService,
    ) {}

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateWatchlistRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateWatchlistRequest $request)
    {
        $validated = $request->validated();

        $imdbId = $validated['imdb_id'];
        $notes = $validated['notes'] ?? null;

        $user = $request->user();

        $status = $this->watchlistService->addMovieIntoList(
            $user,
            $imdbId,
            $notes
        );

        if (!$status) {
            return response()->json([
                'message' => 'Movie did not add to watchlist',
            ], 500);
        }

        $watchlistItem = $this->watchlistService->findByImdbId($imdbId);

        return response()->json([
            'message' => 'Movie added to watchlist',
            'item' => $watchlistItem
        ], 201);
    }

    /**
     * Display a listing of the resource,
     * also supports filtering by status and search query
     *
     * @param WatchlistRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(WatchlistRequest $request)
    {

        $user = $request->user();
        $validated = $request->validated();
        $page = $validated['page'] ?? 1;

        $watchlist = $this->watchlistService->getWatchlist(
            PageDto::apply([
                'page' => $page,
                'perPage' => $validated['perPage'] ?? 10
            ]),
            WatchlistFilterDto::apply([
                'userId' => $user->id,
                'search' => $validated['search'] ?? '',
                'status' => isset($validated['status']) ? Status::tryFrom($validated['status']) : null
            ])
        );

        $data = $watchlist->toArray();

        return response()->json([
            'per_page' => $data['per_page'] ?? 0,
            'current_page' => $data['urrent_page'] ?? (int) $page,
            'last_page' => $data['last_page'] ?? 0,
            'total' => $data['total'] ?? 0,
            'data' => $data['data'] ?? [],
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id)
    {
        $watchlistItem = $this->watchlistService->findById($id);

        if (!$watchlistItem) {
            return response()->json([
                'message' => 'Watchlist item not found',
            ], 404);
        }

        return response()->json(
            $watchlistItem,
            200
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     * @param UpdateWatchlistRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(int $id, UpdateWatchlistRequest $request)
    {
        $watchlistItem = $this->watchlistService->findById($id);

        if (!$watchlistItem) {
            return response()->json([
                'message' => 'Watchlist item not found',
            ], 404);
        }

        $this->authorize('update', $watchlistItem);

        $validated = $request->validated();

        $watchlistItem = $this->watchlistService->update(
            $watchlistItem,
            UpdateWatchlistDto::apply([
                'status' => isset($validated['status']) ? Status::tryFrom($validated['status']) : null,
                'title' => $validated['title'] ?? null,
                'notes' => $validated['notes'] ?? null
            ])
        );

        return response()->json(
            $watchlistItem,
            200
        );
    }

    public function destroy(int $id)
    {
        $watchlistItem = $this->watchlistService->findById($id);

        if (!$watchlistItem) {
            return response()->json([
                'message' => 'Watchlist item not found',
            ], 404);
        }

        $this->authorize('delete', $watchlistItem);

        $this->watchlistService->removeFromWatchlist($id);

        return response()->json([
            'message' => 'Movie removed from watchlist',
        ], 200);
    }
}
