<?php

namespace App\Filament\Resources\ActivityResource\Pages;

use App\Events\ActivityCostCalculation;
use App\Filament\Resources\ActivityResource;
use App\Models\Plane;
use App\Models\Type;
use App\Models\User;
use App\Services\AssetsService;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Throwable;

class CreateActivity extends CreateRecord
{
    protected static string $resource = ActivityResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $getPilotFactorValue = User::where('id', $data['user_id'])->select('factor_id')->get();
        $getPlaneCounterValue = Plane::where('id', $data['plane_id'])->select('counter_type')->get();
        $getPlaneWarmupTypeValue = Plane::where('id', $data['plane_id'])->select('warmup_type')->get();

        $getTypeID = $data['type_id'];
//        $data['rate'] = Type::whereHas('factors', function ($q) use ($getPilotFactorValue, $getTypeID) {
//            $q->where($getPilotFactorValue, $getTypeID)->pivot->rate;
//        })->get();


        if ($data['engine_warmup'] == false) {
            /** industrial minutes calculation */
            if ($getPlaneCounterValue === '100') {
                $data['minutes'] = round(($data['counter_stop']) - ($data['counter_start']) ?? 0 * 100 / 5 * 3, 2) ?? 0;
            }

            /** Rolling hours and minutes with a decimal */
            if ($getPlaneCounterValue === '060') {
                $data['minutes'] = ((intval(data['counter_stop'] ?? 0) * 60) + explode('.', number_format(data['counter_stop'] ?? 0, 2))[1]) - ((intval(data['counter_start'] ?? 0) * 60) + explode('.', number_format(data['counter_start'] ?? 0, 2))[1]);
            }
        }

        if ($data['engine_warmup'] == true) {
            /** industrial minutes calculation */
            if ($getPlaneCounterValue === '100') {
                $data['warmup_minutes'] = round(($data['counter_start']) - ($data['warmup_start']) ?? 0 * 100 / 5 * 3, 2) ?? 0;
                $data['minutes'] = round(($data['counter_stop']) - ($data['counter_start']) ?? 0 * 100 / 5 * 3, 2) ?? 0;
            }
            /** Rolling hours and minutes with a decimal */
            if ($getPlaneCounterValue === '060') {
                $data['warmup_minutes'] = ((intval(data['counter_start'] ?? 0) * 60) + explode('.', number_format(data['counter_start'] ?? 0, 2))[1]) - ((intval(data['warmup_start'] ?? 0) * 60) + explode('.', number_format(data['warmup_start'] ?? 0, 2))[1]);
                $data['minutes'] = ((intval(data['counter_stop'] ?? 0) * 60) + explode('.', number_format(data['counter_stop'] ?? 0, 2))[1]) - ((intval(data['counter_start'] ?? 0) * 60) + explode('.', number_format(data['counter_start'] ?? 0, 2))[1]);
            }
        }

        /** Check if warmup has a cost or not */
        if ($getPlaneWarmupTypeValue == 0) {
            $data['amount'] = $data['minutes'] * $data['rate'] ?? 0;
        }
        if ($getPlaneWarmupTypeValue == 1) {
            $data['amount'] = ($data['minutes'] + $data['warmup_minutes']) * $data['rate'] ?? 0;
        }
        /** Update Asset hours */
        try {
            (new AssetsService())->calculateAssetsRunningHours($data['plane_id']);
        } catch (Throwable $exception) {
            report($exception);
        }

        return $data;
    }

}
