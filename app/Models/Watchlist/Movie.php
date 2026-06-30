<?php

namespace App\Models\Watchlist;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Fillable([
    'imdb_id',
    'title',
    'year',
    'rated',
    'released',
    'runtime',
    'director',
    'plot',
    'language',
    'country',
    'awards',
    'poster',
    'imdb_rating',
    'imdb_votes',
    'type',
])]
class Movie extends Model
{
    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'released' => 'date',
            'year' => 'integer',
            'runtime' => 'integer',
            'imdb_rating' => 'decimal:1',
            'imdb_votes' => 'integer',
        ];
    }

    public function actors(): BelongsToMany
    {
        return $this->belongsToMany(Actor::class);
    }

    public function writers(): BelongsToMany
    {
        return $this->belongsToMany(Writer::class);
    }

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class);
    }
}
