<?php

namespace App\Models\Watchlist;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['name'])]
class Writer extends Model
{
    public function movies(): BelongsToMany
    {
        return $this->belongsToMany(Movie::class);
    }
}
