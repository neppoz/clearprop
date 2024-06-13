<?php

namespace App\Filament\Resources\ReservationResource\Pages;

use App\Filament\Resources\ReservationResource;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReservation extends EditRecord
{
    protected static string $resource = ReservationResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['reservation_start_date'] = Carbon::createFromFormat('Y-m-d H:i:s', $data['reservation_start'])->format('Y-m-d');
        $data['reservation_start_time_hour'] = Carbon::createFromFormat('Y-m-d H:i:s', $data['reservation_start'])->format('H');
        $data['reservation_start_time_minute'] = Carbon::createFromFormat('Y-m-d H:i:s', $data['reservation_start'])->format('i');

        $data['reservation_stop_date'] = Carbon::createFromFormat('Y-m-d H:i:s', $data['reservation_stop'])->format('Y-m-d');
        $data['reservation_stop_time_hour'] = Carbon::createFromFormat('Y-m-d H:i:s', $data['reservation_stop'])->format('H');
        $data['reservation_stop_time_minute'] = Carbon::createFromFormat('Y-m-d H:i:s', $data['reservation_stop'])->format('i');

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['reservation_start'] = $data['reservation_start_date'] . ' ' . $data['reservation_start_time_hour'] . ':' . $data['reservation_start_time_minute'] . ':00';
        $data['reservation_stop'] = $data['reservation_stop_date'] . ' ' . $data['reservation_stop_time_hour'] . ':' . $data['reservation_stop_time_minute'] . ':00';
        $data['created_by_id'] = auth()->id();

        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
