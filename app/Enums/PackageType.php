<?php

namespace App\Enums;

enum PackageType: string
{
    case HOURLY = 'hourly'; // Hourly package
    case FIXED = 'fixed'; // Fixed price package
}
