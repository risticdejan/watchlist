<?php

namespace App\Repositories\Contracts\Movies;

use App\Dtos\Movies\WriterDto;
use App\Models\Movies\Writer;

interface WriterRepository
{
    public function create(WriterDto $dto): Writer;

    public function findByName(string $name): Writer | null;

    public function findOrCreate(WriterDto $dto): Writer;
}
