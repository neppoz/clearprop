<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum RatingStatus: string implements HasColor, HasIcon, HasLabel
{
    case student = 'new';

    case review = 'review';

    case rated = 'rated';

    public function getLabel(): string
    {
        return match ($this) {
            self::student => 'Student',
            self::review => 'in Review',
            self::rated => 'Rated',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::student => 'info',
            self::review => 'warning',
            self::rated => 'success',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::student => 'heroicon-m-sparkles',
            self::review => 'heroicon-m-arrow-path',
            self::rated => 'heroicon-m-x-circle',
        };
    }
}
