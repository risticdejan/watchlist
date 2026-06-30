<?php

namespace App\Models\Movies;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Fillable(['name'])]
class Genre extends Model
{
    public function movies(): BelongsToMany
    {
        return $this->belongsToMany(Movie::class);
    }
}
