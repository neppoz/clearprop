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

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        debug($data);
        $data['rate'] = $data['base_price_per_minute'];

        return $data;
    }
}
