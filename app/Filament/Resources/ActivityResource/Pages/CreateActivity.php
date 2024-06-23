<?php

namespace App\Filament\Resources\ActivityResource\Pages;

use App\Filament\Resources\ActivityResource;
use App\Services\ActivityCostService;
use App\Services\AssetsService;
use Filament\Resources\Pages\CreateRecord;
use Throwable;

class CreateActivity extends CreateRecord
{
    protected static string $resource = ActivityResource::class;

    protected function afterCreate(): void
    {
        /** Calculate costs */
        try {
            (new ActivityCostService)->calculateCosts($this->record);
        } catch (Throwable $exception) {
            report($exception);
        }

        /** Update Asset hours */
        try {
            (new AssetsService())->calculateAssetsRunningHours($this->record->plane_id);
        } catch (Throwable $exception) {
            report($exception);
        }
    }

}
