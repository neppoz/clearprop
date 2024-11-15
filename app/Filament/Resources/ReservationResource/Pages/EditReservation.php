<?php

namespace App\Filament\Resources\ReservationResource\Pages;

use App\Filament\Resources\ReservationResource;
use App\Models\Reservation;
use App\Models\User;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditReservation extends EditRecord
{
    protected static string $resource = ReservationResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['reservation_start_date'] = Carbon::createFromFormat('Y-m-d H:i:s', $data['reservation_start'])->format('Y-m-d');
        $data['reservation_start_time'] = Carbon::createFromFormat('Y-m-d H:i:s', $data['reservation_start'])->format('H:i');
        $data['reservation_stop_date'] = Carbon::createFromFormat('Y-m-d H:i:s', $data['reservation_stop'])->format('Y-m-d');
        $data['reservation_stop_time'] = Carbon::createFromFormat('Y-m-d H:i:s', $data['reservation_stop'])->format('H:i');
        $data['status'] = 1;

        return $data;
    }
    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['reservation_start'] = $data['reservation_start_date'] . ' ' . $data['reservation_start_time'];
        $data['reservation_stop'] = $data['reservation_stop_date'] . ' ' . $data['reservation_stop_time'];

        return $data;
    }

    protected function beforeSave(): void
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
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
