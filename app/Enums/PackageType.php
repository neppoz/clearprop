<?php

namespace App\Enums;

enum PackageType: string
{
    case HOURLY = 'hourly'; // Hourly package, not implemented yet.
    case FIXED = 'fixed'; // Fixed price package
}
