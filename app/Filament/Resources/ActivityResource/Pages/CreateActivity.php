<?php

namespace App\Filament\Resources\ActivityResource\Pages;

use App\Filament\Resources\ActivityResource;
use App\Models\Activity;
use App\Services\ActivityCostService;
use App\Services\AssetsService;
use Filament\Resources\Pages\CreateRecord;
use Throwable;

class CreateActivity extends CreateRecord
{
    protected static string $resource = ActivityResource::class;

    protected function afterCreate(): void
    {
        /** @var Activity $activity */
        $activity = $this->record;
        (new ActivityResource())->calculateCosts($activity);
    }

}
