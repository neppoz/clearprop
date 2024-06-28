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

//    protected function beforeCreate(): void
//    {
//        /** @var Activity $activity */
//        $activity = $this->record;
//        dd($activity);
//        (new ActivityResource())->calculateCosts($activity);
//    }
//
//    protected function afterValidate(): void
//    {
//        $activity = $this->record;
//        debug($activity);
//    }
}
