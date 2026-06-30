<?php

namespace App\Models\Watchlist;

use App\Enums\Status;
use App\Models\Movies\Movie;
use App\Models\User;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'title',
    'user_id',
    'movie_id',
    'imdb_id',
    'status',
    'notes',
])]
class Watchlist extends Model
{
    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'status' => Status::class,
        ];
    }

    /**
     * Get the user that owns the watchlist entry.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the movie in the watchlist.
     */
    public function movie(): BelongsTo
    {
        return $this->belongsTo(Movie::class);
    }
}
