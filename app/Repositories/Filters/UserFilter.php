<?php

namespace App\Repositories\Filters;

use Illuminate\Database\Eloquent\Builder;

class UserFilter
{
    public function __construct(
        private int $userId = 0
    ) {}

    public function __invoke(Builder $query): void
    {
        $query->when(
            value: $this->userId !== 0,
            callback: function (Builder $query): void {
                $query->where(column: 'user_id', operator: $this->userId);
            }
        );
    }
}
