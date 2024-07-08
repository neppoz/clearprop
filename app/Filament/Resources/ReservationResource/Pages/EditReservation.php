<?php

namespace App\Filament\Resources\ReservationResource\Pages;

use App\Filament\Resources\ReservationResource;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

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

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['reservation_start'] = $data['reservation_start_date'] . ' ' . $data['reservation_start_time'];
        $data['reservation_stop'] = $data['reservation_stop_date'] . ' ' . $data['reservation_stop_time'];

        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
