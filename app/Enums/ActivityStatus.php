<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum ActivityStatus: string implements HasColor, HasIcon, HasLabel
{
    case New = 'new';

    case Approved = 'approved';

    public function getLabel(): string
    {
        return match ($this) {
            self::New => 'New',
            self::Approved => 'Approved',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::New => 'info',
            self::Approved => 'success',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::New => 'heroicon-m-sparkles',
            self::Approved => 'heroicon-m-check',
        };
    }
}
