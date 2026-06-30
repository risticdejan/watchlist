<?php

namespace App\Repositories\Filters;

use Illuminate\Database\Eloquent\Builder;

class SearchFilter
{
    public function __construct(
        private string $search = ''
    ) {}

    public function __invoke(Builder $query): void
    {
        $query->when(
            value: $this->search !== '',
            callback: function (Builder $query): void {
                $searchTerm = "%{$this->search}%";
                $query->where(
                    'title',
                    'like',
                    $searchTerm
                );
            }
        );
    }
}
