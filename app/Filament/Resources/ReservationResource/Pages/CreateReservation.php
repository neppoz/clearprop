<?php

namespace App\Filament\Resources\ReservationResource\Pages;

use App\Filament\Resources\ReservationResource;
use App\Models\User;
use App\Services\ReservationValidator;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Exceptions\Halt;
use Illuminate\Support\Facades\Auth;

class CreateReservation extends CreateRecord
{
    protected static string $resource = ReservationResource::class;

    /**
     * Perform checks before filling the form.
     */
    protected function beforeFill(): void
    {
        $currentUser = Auth::user();

        // Check if the current user is neither admin nor manager
        if (!$currentUser->is_admin && !$currentUser->is_manager) {
            // Validate the current user's medical and balance
            if (!ReservationValidator::validateMedical($currentUser) || !ReservationValidator::validateBalance($currentUser)) {
                Notification::make()
                    ->title('Reservation Denied')
                    ->body('You cannot create a reservation. Medical or balance is invalid.')
                    ->danger()
                    ->send();

                // Redirect to the resource index page
                $this->redirect($this->getResource()::getUrl());
            }
        }
    }


    /**
     * Perform checks before creating the record.
     * @throws Halt
     */
    protected function beforeCreate(): void
    {
        $data = $this->data;

        // Retrieve the selected user from form data
        $selectedUser = User::find($data['user_id']);

        // Todo: Refactor this, for the moment commented out everything
//        if (!ReservationValidator::validateAll($data, $selectedUser)) {
//            $this->halt();
//        }
    }

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
