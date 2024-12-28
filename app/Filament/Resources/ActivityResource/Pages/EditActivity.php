<?php

namespace App\Filament\Resources\ActivityResource\Pages;

use App\Filament\Resources\ActivityResource;
use App\Models\Package;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

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

    protected function mutateFormDataBeforeFill(array $data): array
    {
        Log::channel('pricing')->info(str_repeat('=', 50));
        Log::channel('pricing')->info('Edit process started for Activity', ['record_id' => $this->record->id]);
        Log::channel('pricing')->info(str_repeat('=', 50));

        return parent::mutateFormDataBeforeFill($data);
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Check if relevant form data changed using raw values from the database
        $userChanged = $this->record->getRawOriginal('user_id') !== $data['user_id'];
        $planeChanged = $this->record->getRawOriginal('plane_id') !== $data['plane_id'];
        $instructorChanged = $this->record->getRawOriginal('instructor_id') !== $data['instructor_id'];
        $minutesChanged = $this->record->getRawOriginal('minutes') !== $data['minutes'];
        $eventChanged = $this->record->getRawOriginal('event') !== $data['event'];

        // Log the detected changes
        $changes = [];
        if ($userChanged) {
            $changes['user_id'] = [
                'old' => $this->record->getRawOriginal('user_id'),
                'new' => $data['user_id'],
            ];
        }
        if ($planeChanged) {
            $changes['plane_id'] = [
                'old' => $this->record->getRawOriginal('plane_id'),
                'new' => $data['plane_id'],
            ];
        }
        if ($instructorChanged) {
            $changes['instructor_id'] = [
                'old' => $this->record->getRawOriginal('instructor_id'),
                'new' => $data['instructor_id'],
            ];
        }
        if ($minutesChanged) {
            $changes['minutes'] = [
                'old' => $this->record->getRawOriginal('minutes'),
                'new' => $data['minutes'],
            ];
        }
        if ($eventChanged) {
            $changes['event'] = [
                'old' => $this->record->getRawOriginal('event'),
                'new' => $data['event'],
            ];
        }

        if (!empty($changes)) {
            Log::channel('pricing')->info('Detected changes for Activity', [
                'record_id' => $this->record->id,
                'changes' => $changes,
            ]);
        }

        $recalculatePackage = $userChanged || $planeChanged || $instructorChanged || $eventChanged;

        \DB::transaction(function () use (&$data, $recalculatePackage, $minutesChanged) {
            // If package has to be recalculated
            if ($recalculatePackage) {
                // Reset old package
                $oldPackage = Package::find($this->record->getRawOriginal('package_id'));
                if ($oldPackage) {
                    $oldPackage->remaining_minutes += $this->record->minutes; // Reset to previous minutes
                    $oldPackage->save();

                    Log::channel('pricing')->info('Reset previous package', [
                        'package_id' => $oldPackage->id,
                        'remaining_minutes' => $oldPackage->remaining_minutes,
                    ]);
                }

                // Neues Paket suchen
                $newPackage = $this->findAppropriatePackage($data);

                if ($newPackage) {
                    $data['package_id'] = $newPackage->id;
                    $data['remaining_minutes'] = max(0, $newPackage->remaining_minutes - $data['minutes']);
                    $newPackage->remaining_minutes = $data['remaining_minutes'];
                    $newPackage->save();

                    Log::channel('pricing')->info('New package set', [
                        'package_id' => $newPackage->id,
                        'remaining_minutes' => $newPackage->remaining_minutes,
                    ]);
                } else {
                    // No applicable package found
                    $data['package_id'] = null;
                    $data['remaining_minutes'] = null;

                    Log::channel('pricing')->info('No applicable package found', [
                        'user_id' => $data['user_id'],
                        'plane_id' => $data['plane_id'],
                        'instructor_id' => $data['instructor_id'],
                        'event' => $data['event'],
                    ]);
                }
            }

            // Only minutes changed on existing package
            if ($minutesChanged && !$recalculatePackage) {
                $package = Package::find($this->record->getRawOriginal('package_id'));

                if ($package) {
                    $minuteDifference = $data['minutes'] - $this->record->minutes;
                    $package->remaining_minutes = max(0, $package->remaining_minutes - $minuteDifference);
                    $package->save();

                    Log::channel('pricing')->info('Package changed based on minutes change', [
                        'package_id' => $package->id,
                        'minute_difference' => $minuteDifference,
                        'remaining_minutes' => $package->remaining_minutes,
                    ]);
                }
            }
        });

        Log::channel('pricing')->info('Activity record edit:', $data);
        Log::channel('pricing')->info(str_repeat('-', 50));
        Log::channel('pricing')->info('Edit process completed', ['record_id' => $this->record->id]);
        Log::channel('pricing')->info(str_repeat('-', 50));

        return $data;
    }

    protected function findAppropriatePackage(array $data): ?\App\Models\Package
    {
        $userId = $data['user_id'];
        $planeId = $data['plane_id'];
        $instructorId = $data['instructor_id'] ?? null;
        $eventDate = Carbon::parse($data['event']);

        return Package::query()
            ->where('user_id', $userId)
            ->where(function ($query) use ($planeId) {
                $query->whereNull('plane_id')
                    ->orWhere('plane_id', $planeId);
            })
            ->when($instructorId !== null, function ($query) {
                $query->where('instructor_included', true);
            })
            ->whereDate('valid_from', '<=', $eventDate)
            ->whereDate('valid_until', '>=', $eventDate)
            ->first();
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
