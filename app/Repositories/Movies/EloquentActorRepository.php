<?php

namespace App\Repositories\Movies;

use App\Dtos\Movies\ActorDto;
use App\Models\Movies\Actor;
use App\Repositories\Contracts\Movies\ActorRepository;

class EloquentActorRepository implements ActorRepository
{
    /**
     * @param ActorDto $dto
     * @return Actor
     */
    public function create(ActorDto $dto): Actor
    {
        return Actor::create(['name' => $dto->name]);
    }

    /**
     * @param string $name
     * @return Actor|null
     */
    public function findByName(string $name): Actor|null
    {
        return Actor::query()->where('name', $name)->first();
    }

    /**
     * @param ActorDto $dto
     * @return Actor
     */
    public function findOrCreate(ActorDto $dto): Actor
    {
        return Actor::firstOrCreate(['name' => $dto->name]);
    }
}
