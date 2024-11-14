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
        $data['status'] = Reservation::STATUS_RADIO['1'];
        return $data;
    }

    public function getHeaderWidgets(): array
    {
        return ReservationResource::getWidgets();
    }

    protected function beforeCreate(): void
    {
        // Prüfe, ob der Benutzer die Admin-Rolle hat
        if (Auth::user()->is_admin) {
            // Überspringe die Überschneidungsprüfung für Admin-Benutzer
            return;
        }

        $data = $this->data;

        // Definiere die Start- und Endzeiten aus den Form-Daten
        $startTime = $data['reservation_start_date'] . ' ' . $data['reservation_start_time'];
        $endTime = $data['reservation_stop_date'] . ' ' . $data['reservation_stop_time'];
        $planeId = $data['plane_id'];

        $overlappingBooking = Plane::where('id', $planeId)
            ->whereHas('planeBookings', function ($query) use ($startTime, $endTime) {
                $query->where(function ($query) use ($startTime, $endTime) {
                    // Abfrage für echte Überschneidungen mit vollständigem Datum und Zeit
                    $query->where('reservation_start', '<', $endTime)
                        ->where('reservation_stop', '>', $startTime);
                });
            })->exists();

        // Falls Überschneidungen gefunden wurden, Speichervorgang abbrechen und eine Notification anzeigen
        if ($overlappingBooking) {
            Notification::make()
                ->title('Reservation overlapping')
                ->body('This reservation overlaps with a previous reservation. Please select different period.')
                ->danger() // Optionale Markierung, um die Nachricht als kritisch zu kennzeichnen
                ->send();

            $this->halt();
        }
    }
}
