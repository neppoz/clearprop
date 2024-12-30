<?php

namespace App\Filament\Resources\ReservationResource\Pages;

use App\Filament\Resources\ReservationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReservations extends ListRecords
{
    protected static string $resource = ReservationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getHeaderWidgets(): array
    {
        $user = auth()->user();

        // Check policy
        if (!$user->can('create', \App\Models\Reservation::class)) {
            // show widget what are the issues
            return array_merge(
                [\App\Filament\Resources\ReservationResource\Widgets\ReservationRestrictionWidget::class],
                ReservationResource::getWidgets(),
            );
        }

        return ReservationResource::getWidgets();
    }
}
