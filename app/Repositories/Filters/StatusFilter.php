<?php

namespace App\Repositories\Filters;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Builder;

class StatusFilter
{
    public function __construct(
        private ?Status $status
    ) {}

    public function __invoke(Builder $query): void
    {
        $query->when(
            value: $this->status !== '',
            callback: function (Builder $query): void {
                switch ($this->status) {
                    case Status::TO_WATCH:
                        $query->where(
                            'status',
                            $this->status->value
                        );
                        break;
                    case Status::WATCHING:
                        $query->where(
                            'status',
                            $this->status->value
                        );
                        break;

                    case Status::WATCHED:
                        $query->where(
                            'status',
                            $this->status->value
                        );
                        break;
                    default:

                        break;
                }
            }
        );
    }
}
