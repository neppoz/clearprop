<?php

namespace App\Filament\Resources\ReservationResource\Pages;

use App\Filament\Resources\ReservationResource;
use App\Models\Plane;
use App\Models\Reservation;
use App\Models\User;
use App\Services\ReservationValidator;
use App\Settings\GeneralSettings;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Exceptions\Halt;
use Illuminate\Support\Facades\Auth;

class EditReservation extends EditRecord
{
    protected static string $resource = ReservationResource::class;

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

    /**
     * Perform checks before saving the record.
     * @throws Halt
     */
    protected function beforeSave(): void
    {
        $data = $this->data;

        $validationChecksForCurrentRecordPassed = (new ReservationResource())->validateReservation($data);

        // If something else than true comes back, halt the process now!
        if (!$validationChecksForCurrentRecordPassed) {
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

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl();
    }
}
