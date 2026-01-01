<?php

namespace App\Observers;

use App\Models\Activity;
use App\Services\AssetsService;

class ActivityObserver
{
    public function __construct(private AssetsService $assetsService)
    {
    }

    public function created(Activity $activity): void
    {
        if ($activity->plane_id) {
            $this->assetsService->calculateAssetsRunningHours($activity->plane_id);
        }
    }

    public function updated(Activity $activity): void
    {
        if ($activity->plane_id && $activity->isDirty(['minutes', 'plane_id', 'event'])) {
            $this->assetsService->calculateAssetsRunningHours($activity->plane_id);

            // If plane_id changed, also recalculate for the old plane
            if ($activity->isDirty('plane_id') && $activity->getOriginal('plane_id')) {
                $this->assetsService->calculateAssetsRunningHours($activity->getOriginal('plane_id'));
            }
        }
    }

    public function deleted(Activity $activity): void
    {
        if ($activity->plane_id) {
            $this->assetsService->calculateAssetsRunningHours($activity->plane_id);
        }
    }

    public function restored(Activity $activity): void
    {
        if ($activity->plane_id) {
            $this->assetsService->calculateAssetsRunningHours($activity->plane_id);
        }
    }
}
