<?php

namespace App\Filament\Resources\PackageResource\Pages;

use App\Filament\Resources\PackageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPackage extends EditRecord
{
    protected static string $resource = PackageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // If initial_minutes changes, adjust remaining_minutes
        $originalData = $this->record->getOriginal();
        if (isset($data['initial_minutes']) && $data['initial_minutes'] !== $originalData['initial_minutes']) {
            $difference = $data['initial_minutes'] - $originalData['initial_minutes'];
            $data['remaining_minutes'] = max(0, $this->record->remaining_minutes + $difference);
        }

        return $data;
    }
}
