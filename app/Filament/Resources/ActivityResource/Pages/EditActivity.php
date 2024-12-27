<?php

namespace App\Filament\Resources\ActivityResource\Pages;

use App\Filament\Resources\ActivityResource;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions;

class EditActivity extends EditRecord
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

    protected function mutateFormDataBeforeSave(array $data): array
    {
        //ToDo: logic if minuntes changes and remaining_minutes delta calculation
        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }


}
