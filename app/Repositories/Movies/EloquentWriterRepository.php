<?php

namespace App\Repositories\Movies;

use App\Dtos\Movies\WriterDto;
use App\Models\Movies\Writer;
use App\Repositories\Contracts\Movies\WriterRepository;

class EloquentWriterRepository implements WriterRepository
{
    /**
     * @param WriterDto $dto
     * @return Writer
     */
    public function create(WriterDto $dto): Writer
    {
        return Writer::create(['name' => $dto->name]);
    }

    /**
     * @param string $name
     * @return Writer | null
     */
    public function findByName(string $name): Writer | null
    {
        return Writer::query()->where('name', $name)->first();
    }

    /**
     * @param WriterDto $dto
     * @return Writer
     */
    public function findOrCreate(WriterDto $dto): Writer
    {
        return Writer::firstOrCreate(['name' => $dto->name]);
    }
}
