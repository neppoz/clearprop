<?php

namespace App\Filament\Resources\ReservationResource\Pages;

use App\Filament\Resources\ReservationResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateReservation extends CreateRecord
{
    protected static string $resource = ReservationResource::class;
    public bool $showWarningModal = false;
    public ?string $warningTitle = null;
    public ?string $warningDescription = null;

    protected function beforeFill(): void
    {
        $this->checkCreatePermission();
    }

    protected function checkCreatePermission(): void
    {
//        if (!ReservationResource::canCreateReservation()) {
        $this->warningTitle = 'Reservierung nicht möglich';
        $this->warningDescription = 'Du kannst derzeit keine Reservierungen tätigen. Bitte folge den Anweisungen.';
        $this->showWarningModal = true;
//        }
    }

    public function redirectToIndex(): void
    {
        $this->redirect($this->getRedirectUrl());
    }
    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }

    public function render(): \Illuminate\Contracts\View\View
    {
        return view('filament.resources.reservation.create');
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
