<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum AssetCategory: string implements HasLabel
{
    case Propeller = 'propeller';
    case Engine = 'engine';
    case Airframe = 'airframe';
    case Advanced = 'advanced';

    public function getLabel(): string
    {
        return match ($this) {
            self::Propeller => __('assets.categories.propeller'),
            self::Engine => __('assets.categories.engine'),
            self::Airframe => __('assets.categories.airframe'),
            self::Advanced => __('assets.categories.advanced'),
        };
    }
}
