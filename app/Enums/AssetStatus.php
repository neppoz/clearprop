<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum AssetStatus: string implements HasColor, HasIcon, HasLabel
{
    case Active = 'active';
    case Inactive = 'inactive';
    case Broken = 'broken';
    case OutForRepair = 'out_for_repair';

    public function getLabel(): string
    {
        return match ($this) {
            self::Active => __('assets.statuses.active'),
            self::Inactive => __('assets.statuses.inactive'),
            self::Broken => __('assets.statuses.broken'),
            self::OutForRepair => __('assets.statuses.out_for_repair'),
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Active => 'success',
            self::Inactive => 'gray',
            self::Broken => 'danger',
            self::OutForRepair => 'warning',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Active => 'heroicon-m-check-circle',
            self::Inactive => 'heroicon-m-pause-circle',
            self::Broken => 'heroicon-m-x-circle',
            self::OutForRepair => 'heroicon-m-wrench',
        };
    }
}
