<?php

namespace App\Enums;

enum EventDateStatus: string
{
    case UPCOMING = 'Upcoming';
    case ONGOING  = 'Ongoing';
    case EXPIRED  = 'Expired';
    case UNKNOWN  = 'Unknown';
}
