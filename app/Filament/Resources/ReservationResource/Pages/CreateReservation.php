<?php

namespace App\Filament\Resources\ReservationResource\Pages;

use App\Filament\Resources\ReservationResource;
use App\Settings\GeneralSettings;
use Carbon\Carbon;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateReservation extends CreateRecord
{
    protected static string $resource = ReservationResource::class;
    protected function beforeFill(): void
    {
        if (!Auth::user()->is_admin) {
            if (!ReservationResource::validateAll()) {
                // Weiterleitung zur vorherigen Seite oder Index-Seite der Resource
                $this->redirect($this->getResource()::getUrl());
            }
        }
    }
    protected function beforeCreate(): void
    {
        if (!Auth::user()->is_admin) {
            if (ReservationResource::hasOverlappingReservation($this->data)) {
                Notification::make()
                    ->title('Reservation overlapping')
                    ->body('This reservation overlaps with a previous reservation. Please select a different period.')
                    ->danger() // Optionale Markierung, um die Nachricht als kritisch zu kennzeichnen
                    ->send();

                // Speichervorgang abbrechen
                $this->halt();
            }

            $checkActivitySetting = app(GeneralSettings::class)->check_activities;
            if ($checkActivitySetting) {
                if (ReservationResource::hasAirworthinessExpired($this->data)) {
                    Notification::make()
                        ->title('Airworthiness expired.')
                        ->body('Your airworthiness for the selected aircraft has expired.')
                        ->danger() // Optionale Markierung, um die Nachricht als kritisch zu kennzeichnen
                        ->send();

                    // Speichervorgang abbrechen
                    $this->halt();
                }
            }
        }
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['reservation_start'] = $data['reservation_start_date'] . ' ' . $data['reservation_start_time'];
        $data['reservation_stop'] = $data['reservation_stop_date'] . ' ' . $data['reservation_stop_time'];
        $data['created_by_id'] = Auth::id();
        $data['status'] = 1;

        return $data;
    }
    protected function getRedirectUrl(): string
    {
        // Weiterleitung zur Index-Seite der Ressource
        return $this->getResource()::getUrl('index');
    }
    public function getHeaderWidgets(): array
    {
        return ReservationResource::getWidgets();
    }
}
