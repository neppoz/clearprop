<?php


namespace App\Services;

use App\Activity;
use App\Asset;
use Carbon\Carbon;
use Throwable;

class AssetsService
{
    public function calculateAssetsRunningHours($plane_id): void
    {
        try {
            $activeAssetsByPlane = Asset::where('plane_id', $plane_id)->where('status_id', 1)->get();

            foreach ($activeAssetsByPlane as $asset) {
                $runningHoursByAsset = Activity::where('plane_id', $asset->plane_id)
                    ->whereBetween('event', [
                        Carbon::createFromFormat(config('panel.date_format'), $asset->start_date)->format('Y-m-d'),
                        Carbon::createFromFormat(config('panel.date_format'), $asset->end_date)->format('Y-m-d')
                    ])->sum('minutes');
                $asset->current_running_hours = round(($runningHoursByAsset / 60));
                //debug('Asset ID: ' . $asset->id . ' RunningHH: ' . $asset->current_running_hours);
                $asset->save();
            }

            return;
            /** */
        } catch (Throwable $exception) {
            report($exception);
        }
    }
}
