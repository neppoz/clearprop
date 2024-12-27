<?php

namespace App\Filament\Resources\ActivityResource\Pages;

use App\Filament\Resources\ActivityResource;
use App\Models\Package;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Pages\CreateRecord;

class CreateActivity extends CreateRecord
{
    use CreateRecord\Concerns\HasWizard;

    protected static string $resource = ActivityResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }

    public function getSteps(): array
    {
        return ((new ActivityResource())->getSteps());
    }

    protected function calculateResults(Get $get, Set $set): void
    {
        (new ActivityResource())->calculateResults($get, $set);

    }

    protected function collectInputs(Get $get): array
    {
        return (new ActivityResource())->collectInputs($get);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // If a package is used, calculate the remaining minutes and save it to table
        $packageUsed = $data['package_used'];
        $packageId = $data['package_id'];
        $remainingMinutes = $data['remaining_minutes'];

        if ($packageUsed && !empty($packageId) && !empty($remainingMinutes)) {
            $package = Package::find($packageId);
            if ($package) {
                // Directly update the raw value in the database to avoid Accessor interference
                $package->setRawAttributes([
                    'remaining_minutes' => $remainingMinutes,
                ]);
                $package->save();
            }
        }

        return $data;
    }
}
