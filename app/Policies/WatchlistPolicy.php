<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Watchlist\Watchlist;

class WatchlistPolicy
{
    /**
     * Determine if the given watchlist can be updated by the user.
     */
    public function update(User $user, Watchlist $watchlist): bool
    {
        return $user->id === $watchlist->user_id;
    }

    /**
     * Determine if the given watchlist can be deleted by the user.
     */
    public function delete(User $user, Watchlist $watchlist): bool
    {
        return $user->id === $watchlist->user_id;
    }
}
