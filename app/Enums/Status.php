<?php

namespace App\Enums;

enum Status: string
{
    case TO_WATCH = 'to_watch';
    case WATCHING = 'watching';
    case WATCHED = 'watched';
}
