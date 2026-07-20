<?php

namespace App\Enums;

enum RsvpStatus: string
{
    case Hadir = 'hadir';
    case TidakHadir = 'tidak_hadir';
    case Ragu = 'ragu';
}
