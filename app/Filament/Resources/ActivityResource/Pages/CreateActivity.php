<?php

namespace App\Filament\Resources\ActivityResource\Pages;

use App\Enums\ActivityStatus;
use App\Filament\Resources\ActivityResource;
use App\Models\Package;
use App\Models\User;
use App\Services\ActivityCalculationService;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Pages\CreateRecord;
use Filament\Forms;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
        return [
            Forms\Components\Wizard\Step::make('General Information')
                ->completedIcon('heroicon-m-hand-thumb-up')
                ->schema([
                    Forms\Components\DatePicker::make('event')
                        ->label('Date')
                        ->native(true)
                        ->reactive()
                        ->required(),

                    Forms\Components\Select::make('plane_id')
                        ->label('Aircraft')
                        ->preload()
                        ->native(true)
                        ->reactive()
                        ->relationship('plane', 'callsign')
                        ->required(),

                    Forms\Components\Select::make('user_id')
                        ->label('PIC')
                        ->searchable()
                        ->preload()
                        ->native(true)
                        ->reactive()
                        ->options(User::all()->pluck('name', 'id'))
                        ->default(fn() => Auth::user()->is_member ? Auth::id() : null)
                        ->disabled(fn(): bool => Auth::user()->is_member)
                        ->saveRelationshipsWhenDisabled(true)
                        ->relationship(name: 'user', titleAttribute: 'name')
                        ->required(),

                    Forms\Components\Select::make('instructor_id')
                        ->label('Instructor')
                        ->preload()
                        ->native(true)
                        ->reactive()
                        ->searchable()
                        ->options(User::instructors()->pluck('name', 'id')),
                ])
                ->afterStateUpdated(fn(Get $get, Set $set) => $this->calculateResults($set))
                ->columns(2),

            Forms\Components\Wizard\Step::make('Flight Details')
                ->completedIcon('heroicon-m-hand-thumb-up')
                ->schema([
                    Forms\Components\TextInput::make('departure')
                        ->label('Departure')
                        ->maxLength(255),

                    Forms\Components\TimePicker::make('event_start')
                        ->label('Engine On')
                        ->seconds(false)
                        ->live(onBlur: true)
                        ->native(true)
                        ->reactive()
                        ->required(fn(Get $get): bool => (new ActivityResource)->setRequiredEventTime($get)),

                    Forms\Components\TextInput::make('arrival')
                        ->label('Arrival')
                        ->maxLength(255),

                    Forms\Components\TimePicker::make('event_stop')
                        ->label('Engine Off')
                        ->seconds(false)
                        ->native(true)
                        ->reactive()
                        ->afterStateUpdated(fn(Set $set, Get $get, $state) => $get('event_start') && $state < $get('event_start')
                            ? $set('event_stop', null)
                            : null
                        )
                        ->minDate(fn(Get $get) => $get('event_start'))
                        ->required(fn(Get $get): bool => (new ActivityResource)->setRequiredEventTime($get)),
                ])
                ->afterStateUpdated(fn(Get $get, Set $set) => $this->calculateResults($set))
                ->columns(2),

            Forms\Components\Wizard\Step::make('Hobbs')
                ->completedIcon('heroicon-m-hand-thumb-up')
                ->schema([
                    Forms\Components\TextInput::make('counter_start')
                        ->label('Counter Start')
                        ->numeric(2, ',', '.')
                        ->inputMode('decimal')
                        ->minValue(1)
                        ->required(fn(Get $get): bool => (new ActivityResource)->setRequiredCounter($get)),

                    Forms\Components\TextInput::make('counter_stop')
                        ->label('Counter Stop')
                        ->numeric(2, ',', '.')
                        ->inputMode('decimal')
                        ->minValue(fn(Get $get) => $get('counter_start'))
                        ->required(fn(Get $get): bool => (new ActivityResource)->setRequiredCounter($get)),
                ])
                ->afterStateUpdated(fn(Get $get, Set $set) => $this->calculateResults($set))
                ->columns(2),

            Forms\Components\Wizard\Step::make('Remarks')
                ->schema([
                    Forms\Components\Textarea::make('description')
                        ->label('Remarks')
                        ->autosize()
                        ->rows(5)->columnSpan(2),

                    Forms\Components\Group::make()
                        ->schema([
                            Forms\Components\Placeholder::make('minutes')
                                ->label('Minutes')
                                ->inlineLabel()
                                ->content(fn(Get $get) => $get('minutes') .
                                    ($get('minutes') >= 60
                                        ? ' (' . floor($get('minutes') / 60) . 'h ' . str_pad($get('minutes') % 60, 2, '0', STR_PAD_LEFT) . 'm)'
                                        : ''
                                    )
                                ),

                            Forms\Components\Placeholder::make('amount')
                                ->label('Total Price')
                                ->inlineLabel()
                                ->content(fn(Get $get) => number_format((float)($get('amount') ?? 0), 2, ',', '.') . ' €'),

                            Forms\Components\Placeholder::make('pricing_logic')
                                ->label('Pricelist')
                                ->inlineLabel()
                                ->content(fn(Get $get) => $get('pricing_logic') ?? 'N/A'),


                            Forms\Components\Placeholder::make('package_name')
                                ->label('Package Name')
                                ->inlineLabel()
                                ->content(fn(Get $get) => $get('package_name') ?? 'N/A')
                                ->hidden(fn(Get $get) => $get('package_used') == false),

                            Forms\Components\Placeholder::make('remaining_time')
                                ->label('Remaining Time')
                                ->inlineLabel()
                                ->content(function (Get $get) {
                                    $remainingMinutes = $get('remaining_minutes') ?? 0;
                                    $hours = floor($remainingMinutes / 60);
                                    $minutes = $remainingMinutes % 60;

                                    return "{$hours}h {$minutes}m";
                                })
                                ->hidden(fn(Get $get) => $get('package_used') == false),

                            // Hidden fields in form, needed for saving remaining_minutes in mutator
                            Forms\Components\Hidden::make('package_used')
                                ->default(fn(Get $get) => $get('package_used') ?? false),
                            Forms\Components\Hidden::make('package_id')
                                ->default(fn(Get $get) => $get('package_id') ?? null),
                            Forms\Components\Hidden::make('remaining_minutes')
                                ->default(fn(Get $get) => $get('remaining_minutes') ?? null)


                        ]),

                    Forms\Components\Group::make()
                        ->schema([
                            Forms\Components\Radio::make('status')
                                ->options([
                                    ActivityStatus::New->value => 'New',
                                    ActivityStatus::Approved->value => 'Approved'
                                ])
                                ->default(ActivityStatus::New->value)
                                ->required(),
                        ])
                ])
                ->columns(2)
        ];
    }

    protected function calculateResults($set): void
    {
        $inputs = $this->collectInputs();
        Log::channel('pricing')->info('Form inputs:', $inputs);
        $service = app(ActivityCalculationService::class);

        if ($service->validateInputs($inputs)) {
            $results = $service->calculate($inputs);
            Log::channel('pricing')->info('Return values from calculation:', $results);
            $set('pricing_logic', $results['pricing_logic']);
            $set('package_used', $results['package_used']);
            $set('package_name', $results['package_name']);
            $set('package_id', $results['package_id']);
            $set('used_minutes', $results['used_minutes']);
            $set('remaining_minutes', $results['remaining_minutes']);
            $set('minutes', $results['minutes']);
            $set('amount', $results['amount']);
        } else {
            $set('minutes', 0);
            $set('amount', 0);
        }
    }

    protected function collectInputs(): array
    {
        return [
            'event' => $this->data['event'],
            'plane_id' => $this->data['plane_id'],
            'user_id' => $this->data['user_id'],
            'event_start' => $this->data['event_start'],
            'event_stop' => $this->data['event_stop'],
            'counter_start' => $this->data['counter_start'],
            'counter_stop' => $this->data['counter_stop'],
        ];
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
