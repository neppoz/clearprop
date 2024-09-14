<?php

namespace App\Filament\Resources\PlaneResource\Pages;

use App\Filament\Resources\PlaneResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPlanes extends ListRecords
{
    protected static string $resource = PlaneResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
