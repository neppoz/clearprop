<?php

namespace App\Filament\Resources\ReservationResource\Pages;

use App\Filament\Resources\ReservationResource;
use App\Models\Plane;
use App\Models\Reservation;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateReservation extends CreateRecord
{
    protected static string $resource = ReservationResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['reservation_start'] = $data['reservation_start_date'] . ' ' . $data['reservation_start_time'];
        $data['reservation_stop'] = $data['reservation_stop_date'] . ' ' . $data['reservation_stop_time'];
        $data['created_by_id'] = Auth::id();
        $data['status'] = 1;

        return $data;
    }
    protected function beforeCreate(): void
    {
        // Prüfe auf Überschneidungen
        if (ReservationResource::hasOverlappingReservation($this->data)) {
            Notification::make()
                ->title('Reservation overlapping')
                ->body('This reservation overlaps with a previous reservation. Please select a different period.')
                ->danger() // Optionale Markierung, um die Nachricht als kritisch zu kennzeichnen
                ->send();

            // Speichervorgang abbrechen
            $this->halt();
        }
    }

    public function getHeaderWidgets(): array
    {
        return ReservationResource::getWidgets();
    }
}
