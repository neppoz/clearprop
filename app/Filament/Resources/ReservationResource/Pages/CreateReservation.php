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

        $user = auth()->user();
        $settings = app(GeneralSettings::class);
        $selectedAircraft = Plane::where('id', $data['plane_id'])->first();
        $reservationStartDate = Carbon::parse($data['reservation_start_date']);

        // Check if balance validation is enabled
        if ($user->is_member && $settings->check_activities) {
            // Validate airworthiness if enabled
            $airWorthiness = (new ReservationValidator())->validateAirworthiness($reservationStartDate, $selectedAircraft, $user);

            if (!$airWorthiness) {
                Notification::make()
                    ->title("Airworthiness for {$selectedAircraft->callsign} expired")
                    ->body('Please select a different aircraft or contact administrator.')
                    ->danger()
                    ->send();

                $this->halt();
            }
        }
        // ToDo New Logic. If the user who operates this form is a member then check: validateAirworthiness and validateOverlappingReservation
//        $data = $this->data;
//
//        // Retrieve the selected user from form data
//        $selectedUser = User::find($data['user_id']);
//
//        // Validate the airworthiness
//        if (!ReservationValidator::validateAll($data, $selectedUser)) {
//            $this->halt();
//        }
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
