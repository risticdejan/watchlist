<?php

namespace App\Repositories\Contracts\Movies;

use App\Dtos\Movies\ActorDto;
use App\Models\Movies\Actor;

interface ActorRepository
{
    public function create(ActorDto $dto): Actor;

    public function findByName(string $name): Actor | null;

    public function findOrCreate(ActorDto $dto): Actor;
}
