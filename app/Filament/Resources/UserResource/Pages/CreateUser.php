<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $role = $data['role'] ?? null;

        unset($data['role']);

        return $data;
    }

    protected function afterCreate(): void
    {
        if ($this->data['role']) {
            $this->record->syncRoles([$this->data['role']]);
        }
    }

}
