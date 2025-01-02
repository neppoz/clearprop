<?php

namespace App\Filament\Resources\ReservationResource\Widgets;

use Filament\Widgets\Widget;

class ReservationRestrictionWidget extends Widget
{
    protected static string $view = 'filament.widgets.reservation-restriction';

    public static function canView(): bool
    {
        $user = auth()->user();

        // Widget only shown when no reservation possible
        return !$user->can('create', \App\Models\Reservation::class);
    }

    public function getColumnSpan(?string $breakpoint = null): int|string
    {
        return 'full'; // Use full span
    }
}
