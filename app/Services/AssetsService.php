<?php


namespace App\Services;

use App\Enums\AssetStatus;
use App\Models\Activity;
use App\Models\Asset;
use Throwable;

class AssetsService
{
    public function calculateAssetsRunningHours($plane_id): void
    {
        try {
            $activeAssetsByPlane = Asset::where('plane_id', $plane_id)->where('status', AssetStatus::Active)->get();

            foreach ($activeAssetsByPlane as $asset) {
                if (!$asset->start_date || !$asset->end_date) {
                    continue;
                }

                $runningHoursByAsset = Activity::where('plane_id', $asset->plane_id)
                    ->whereBetween('event', [
                        $asset->start_date->format('Y-m-d'),
                        $asset->end_date->format('Y-m-d')
                    ])->sum('minutes');
                $asset->current_running_hours = round(($runningHoursByAsset / 60));
                $asset->save();
            }

            return;
            /** */
        } catch (Throwable $exception) {
            report($exception);
        }
    }
}
