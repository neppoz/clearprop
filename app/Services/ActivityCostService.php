<?php

namespace App\Services;

use App\Models\Plane;
use App\Models\Type;
use App\Models\User;
use Illuminate\Support\Arr;

class ActivityCostService
{
    public function calculateCosts($data)
    {
        $getPilotId = User::findOrFail($data['user_id']);
        $getPlaneId = Plane::findOrFail($data['plane_id']);
        $getTypeID = Type::findOrFail($data['type_id']);
        $rate = $getTypeID->factors()->findOrFail($getPilotId->factor_id, ['type_id'])->pivot->rate ?? 0;
        $calculateCounterDiff = $data['counter_stop'] - $data['counter_start'] ?? 0;
        $minutes = 0;
        $amount = 0;
        $warmupMinutes = 0;

        /** Calculation of the minutes */
        if ($data['engine_warmup'] == false) {
            /** industrial minutes calculation */
            if ($getPlaneId->counter_type === '100') {
                $minutes = round($calculateCounterDiff * 100 / 5 * 3, 2);
            }

            /** Rolling hours and minutes with a decimal */
            if ($getPlaneId->counter_type === '060') {
                $minutes = ((intval(data['counter_stop']) * 60) + explode('.', number_format(data['counter_stop'], 2))[1]) - ((intval(data['counter_start']) * 60) + explode('.', number_format(data['counter_start'], 2))[1]);
            }
        }


        if ($data['engine_warmup'] == true) {
            $calculateCounterWarmupDiff = $data['counter_start'] - $data['warmup_start'];
            /** industrial minutes calculation */
            if ($getPlaneId->counter_type === '100') {
                $warmupMinutes = round($calculateCounterWarmupDiff * 100 / 5 * 3, 2) ?? 0;
                $minutes = round($calculateCounterDiff * 100 / 5 * 3, 2) ?? 0;
            }
            /** Rolling hours and minutes with a decimal */
            if ($getPlaneId->counter_type === '060') {
                $warmupMinutes = ((intval(data['counter_start']) * 60) + explode('.', number_format(data['counter_start'], 2))[1]) - ((intval(data['warmup_start']) * 60) + explode('.', number_format(data['warmup_start'], 2))[1]);
                $minutes = ((intval(data['counter_stop']) * 60) + explode('.', number_format(data['counter_stop'], 2))[1]) - ((intval(data['counter_start']) * 60) + explode('.', number_format(data['counter_start'], 2))[1]);
            }
        }

        /** Check if warmup has a cost or not */
        if ($getPlaneId->warmup_type == 0) {
            $amount = $minutes * $rate;
        }
        if ($getPlaneId->warmup_type == 1) {
            $amount = ($minutes + $warmupMinutes) * $rate;
        }

        $data->minutes = $minutes;
        $data->warmup_minutes = $warmupMinutes;
        $data->rate = $rate;
        $data->amount = $amount;
        $data->save();

    }
}
