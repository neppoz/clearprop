<?php

namespace App\Observers;

use App\Models\Asset;
use App\Services\AssetsService;

class AssetObserver
{
    public function __construct(private AssetsService $assetsService)
    {
    }

    public function created(Asset $asset): void
    {
        if ($asset->plane_id) {
            $this->assetsService->calculateAssetsRunningHours($asset->plane_id);
        }
    }

    public function updated(Asset $asset): void
    {
        if ($asset->isDirty('plane_id')) {
            if ($asset->plane_id) {
                $this->assetsService->calculateAssetsRunningHours($asset->plane_id);
            }
            if ($asset->getOriginal('plane_id')) {
                $this->assetsService->calculateAssetsRunningHours($asset->getOriginal('plane_id'));
            }
        }
    }
}
