<?php

namespace App\Filament\Resources\ReservationResource\Pages;

use App\Filament\Resources\ReservationResource;
use App\Models\Plane;
use App\Models\User;
use App\Services\ReservationValidator;
use App\Services\StatisticsService;
use App\Settings\GeneralSettings;
use Carbon\Carbon;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Exceptions\Halt;
use Illuminate\Support\Facades\Auth;

class CreateReservation extends CreateRecord
{
    protected static string $resource = ReservationResource::class;

    /**
     * Mutate form data before creating the record.
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['reservation_start'] = $data['reservation_start_date'] . ' ' . $data['reservation_start_time'];
        $data['reservation_stop'] = $data['reservation_stop_date'] . ' ' . $data['reservation_stop_time'];
        $data['created_by_id'] = Auth::id();
        $data['status'] = 1;

        return $data;
    }

    /**
     * Perform checks before creating the record.
     * @throws Halt
     */
    protected function beforeCreate(): void
    {
        $data = $this->data;

        $validationChecksForCurrentRecordPassed = (new ReservationResource())->validateReservation($data);

        // If something else than true comes back, halt the process now!
        if (!$validationChecksForCurrentRecordPassed) {
            $this->halt();
        }

    }

    /**
     * Redirect to the resource index page after creation.
     */
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    /**
     * Retrieve header widgets for the page.
     */
    public function getHeaderWidgets(): array
    {
        return ReservationResource::getWidgets();
    }
}
