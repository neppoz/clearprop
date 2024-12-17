<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class GeneralSettings extends Settings
{
    public bool $check_medical;
    public bool $check_balance;
    public bool $check_activities;
    public int $check_activities_limit_days;
    public int $check_balance_limit_amount;
    public bool $check_ratings;

    public static function group(): string
    {
        return 'general';
    }
}
