<?php

namespace App\Filament\Resources\ActivityResource\Pages;

use App\Filament\Resources\ActivityResource;
use App\Models\Package;
use App\Services\ActivityCalculationService;
use Filament\Resources\Pages\CreateRecord;

class CreateActivity extends CreateRecord
{
    protected static string $resource = ActivityResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $calculationService = new ActivityCalculationService();

        // Calculate minutes
        $minutesData = $calculationService->calculateMinutes($data);

        // Calculate prices
        $amountData = $calculationService->calculateAmount($data, $minutesData['minutes'], $minutesData['warmup_minutes']);

        // Save data to the array
        $data['minutes'] = $minutesData['minutes'];
        $data['warmup_minutes'] = $minutesData['warmup_minutes'];
        $data['amount'] = $amountData['amount'];
        $data['base_price_per_minute'] = $amountData['base_price_per_minute'];
        $data['instructor_price_per_minute'] = $amountData['instructor_price_per_minute'];
        $data['package_id'] = $amountData['package_id'];
        $data['remaining_package_minutes'] = $amountData['remaining_minutes'];

        // If a package is used, calculate the remaining minutes
        if ($amountData['package_used'] && $amountData['package_id']) {
            $package = Package::find($amountData['package_id']);
            if ($package) {
                // Directly update the raw value in the database to avoid Accessor interference
                $package->setRawAttributes([
                    'remaining_minutes' => $amountData['remaining_minutes'],
                ]);
                $package->save();
            }
        }


        return $data;
    }


}
