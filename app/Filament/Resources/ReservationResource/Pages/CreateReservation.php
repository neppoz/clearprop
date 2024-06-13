<?php

namespace App\Filament\Resources\ReservationResource\Pages;

use App\Activity;
use App\Filament\Resources\ReservationResource;
use App\Income;
use App\Models\Parameter;
use App\Models\Reservation;
use App\Models\User;
use App\Plane;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\CreateRecord\Concerns\HasWizard;
use Illuminate\Support\HtmlString;

class CreateReservation extends CreateRecord
{
    protected static string $resource = ReservationResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['reservation_start'] = $data['reservation_start_date'] . ' ' . $data['reservation_start_time_hour'] . ':' . $data['reservation_start_time_minute'] . ':00';
        $data['reservation_stop'] = $data['reservation_stop_date'] . ' ' . $data['reservation_stop_time_hour'] . ':' . $data['reservation_stop_time_minute'] . ':00';
        $data['created_by_id'] = auth()->id();

        return $data;
    }

    protected function beforeValidate(): void
    {
        debug('beforeValidate');
    }

    protected function afterValidate(): void
    {
        $reservation = $this->record;
        debug($reservation);
    }

    protected function beforeCreate(): void
    {
        debug('beforeCreate');
    }
//    protected function mutateFormDataBeforeCreate(array $data): array
//    {
//        $data['reservation_start_date']);
////        $data['last_edited_by_id'] = auth()->id();
//
//        return $data;
//    }

//    protected function afterCreate(): void
//    {
//        debug('after');
//    }
//        /** @var Order $order */
//        $order = $this->record;
//
//        /** @var User $user */
//        $user = auth()->user();
//
//        Notification::make()
//            ->title('New order')
//            ->icon('heroicon-o-shopping-bag')
//            ->body("**{$order->customer?->name} ordered {$order->items->count()} products.**")
//            ->actions([
//                Action::make('View')
//                    ->url(OrderResource::getUrl('edit', ['record' => $order])),
//            ])
//            ->sendToDatabase($user);


    protected function afterFormValidated(): void
    {
        debug('afterValidation');
    }

//    public static function getUserRatings($user_id): bool
//    {
//        if (!(new CreateReservation)->balanceCheckPassed($user_id)) {
//            Notification::make()
//                ->title('No balance title')
//                ->body('No balance text')
//                ->warning()
//                ->persistent()
//                ->send();
//        }
//
//        if (!(new CreateReservation)->medicalCheckPassed($user_id)) {
//            Notification::make()
//                ->title('No medical title')
//                ->body('No medical text')
//                ->warning()
//                ->persistent()
//                ->send();
//        }
//
//        return true;
//    }

//    /** @return Step[] */
//    protected function getSteps(): array
//    {
//        return [
//            Step::make('Type & Aircraft')
//                ->schema([
//                    Section::make()
//                        ->schema([
//                            Radio::make('type')
//                                ->options([
//                                    1 => 'Charter',
//                                    2 => 'School',
//                                    4 => 'Maintenance'
//                                ])
//                                ->label('Select type')
//                                ->inline()
//                                ->live()
//                                ->required(),
//                            Select::make('aircraft')
//                                ->label('Aircraft')
//                                ->options(\App\Models\Plane::where('active', 1)->pluck('callsign', 'id'))
//                                ->required(),
//                        ])
//                        ->columns(2),
//                    Section::make()
//                        ->schema([
//                            DatePicker::make('reservation_start_date')
//                                ->label('From')
//                                ->native(false)
//                                ->firstDayOfWeek(1)
//                                ->displayFormat('d/m/Y')
//                                ->minDate(now()),
//                            TimePicker::make('reservation_start_time')
//                                ->label('Time from')
//                                ->minutesStep(15)
//                                ->datalist(['07:00', '08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00', '20:00',
//                                ])
//                                ->seconds(false),
//                            DatePicker::make('reservation_stop_date')
//                                ->label('To')
//                                ->native(false)
//                                ->firstDayOfWeek(1)
//                                ->displayFormat('d/m/Y')
//                                ->minDate(now()),
//                            TimePicker::make('reservation_stop_time')
//                                ->label('Time to')
//                                ->minutesStep(15)
//                                ->datalist(['07:00', '08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00', '20:00',
//                                ])
//                                ->seconds(false),
//                        ])
//                        ->columns(2),
//                    Section::make()
//                        ->schema([
//                            Select::make('user')
//                                ->label('Pilot')
//                                ->options(User::all()->pluck('name', 'id'))
//                                ->searchable()
//                                ->afterStateUpdated(fn(Get $get) => self::getUserRatings($get('user_id')))
//                                ->live(onBlur: true)
//                                ->required(fn(Get $get): bool => $get('type') !== 4),
//                            Select::make('instructor')
//                                ->label('Instructor')
//                                ->options(User::instructors()->pluck('name', 'id'))
//                                ->live(onBlur: true)
//                                ->required(fn(Get $get): bool => $get('type') == 2),
//                        ])
//                        ->columns(2),
//                    Section::make()
//                        ->schema([
//                            ToggleButtons::make('status')
//                                ->label('Reservation status')
//                                ->options([
//                                    '0' => 'Draft',
//                                    '1' => 'Confirmed',
//                                ])
//                                ->colors([
//                                    '0' => 'info',
//                                    '1' => 'success',
//                                ])
//                                ->inline()
//                                ->required(),
//                            Textarea::make('description')
//                                ->label('Notes')
//                                ->rows(5)
//                        ])
//                        ->columns(2),
//                ])
//                ->columns(2),
//
//
//            Step::make('Crew & Schedule')
//                ->schema([
//
//
//                ])
//                ->columns(1),
//
////                    Section::make()
////                        ->schema([
////                            Select::make('user_id')
////                                ->label('Pilot')
////                                ->options(User::all()->pluck('name', 'id'))
////                                ->searchable()
////                                ->afterStateUpdated(fn(Get $get) => self::getUserRatings($get('user_id')))
////                                ->live(onBlur: true)
////                                ->required(),
////                            Select::make('aircraft')
////                                ->label('Aircraft')
////                                ->afterStateUpdated(fn(Get $get) => self::getAircraftRatings($get))
////                                ->live(onBlur: true)
////                                ->required(),
////                        ])
////                        ->columns(1),
////        ]),
//
//            Step::make('Review')
//                ->schema([
//
//                ]),
//        ];
//    }
//
//    public function balanceCheckPassed($user_id): bool
//    {
//        if (!(is_null($user_id))) {
//            if (Parameter::where('slug', 'check.balance')->value('value') == Parameter::CHECK_BALANCE_ENABLED) {
//                $activities = Activity::where('user_id', $user_id)
//                    ->whereBetween('event', [now()->startOfYear(), now()])
//                    ->get('amount');
//
//                $incomes = Income::whereHas('income_category', function ($q) {
//                    $q->where('deposit', '=', 1);
//                })
//                    ->where('user_id', $user_id)
//                    ->whereBetween('entry_date', [now()->startOfYear(), now()])
//                    ->get('amount');
//
//                $balance = ($incomes->sum('amount') - abs($activities->sum('amount')));
//                if ($balance <= Parameter::where('slug', 'check.balance.limit.amount')->value('value')) {
//                    return false;
//                }
//
//            }
//            return true;
//        }
//        return true;
//    }
//
//    private function medicalCheckPassed($user_id): bool
//    {
//        if (!(is_null($user_id))) {
//            $user = User::find($user_id);
//            if (Parameter::where('slug', 'check.medical')->value('value') == Parameter::CHECK_MEDICAL_ENABLED) {
//                if (!empty($user->medical_due) && Carbon::createFromFormat(config('panel.date_format'), $user->medical_due)->format('Y-m-d') <= now()) {
//                    return false;
//                }
//            }
//            return true;
//        }
//        return true;
//    }
//
//    public function form(Form $form): Form
//    {
//        return $form
//
////                    Section::make()
////                        ->schema([
////                            Radio::make('type')
////                                ->options([
////                                    1 => 'Charter',
////                                    2 => 'School',
////                                    4 => 'Maintenance'
////                                ])
////                                ->label('Select type')
////                                ->inline()
////                                ->live()
////                                ->required(),
////                            Select::make('aircraft')
////                                ->label('Aircraft')
////                                ->options(\App\Models\Plane::where('active', 1)->pluck('callsign', 'id'))
////                                ->required(),
////                        ])
////                        ->columns(2),
////                    Section::make()
////                        ->schema([
////                            DatePicker::make('reservation_start_date')
////                                ->label('From')
////                                ->native(false)
////                                ->firstDayOfWeek(1)
////                                ->displayFormat('d/m/Y')
////                                ->minDate(now()),
////                            TimePicker::make('reservation_start_time')
////                                ->label('Time from')
////                                ->minutesStep(15)
////                                ->datalist(['07:00', '08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00', '20:00',
////                                ])
////                                ->seconds(false),
////                            DatePicker::make('reservation_stop_date')
////                                ->label('To')
////                                ->native(false)
////                                ->firstDayOfWeek(1)
////                                ->displayFormat('d/m/Y')
////                                ->minDate(now()),
////                            TimePicker::make('reservation_stop_time')
////                                ->label('Time to')
////                                ->minutesStep(15)
////                                ->datalist(['07:00', '08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00', '20:00',
////                                ])
////                                ->seconds(false),
////                        ])
////                        ->columns(2),
////                    Section::make()
////                        ->schema([
////                            Select::make('user')
////                                ->label('Pilot')
////                                ->options(User::all()->pluck('name', 'id'))
////                                ->searchable()
////                                ->afterStateUpdated(fn(Get $get) => self::getUserRatings($get('user_id')))
////                                ->live(onBlur: true)
////                                ->required(fn(Get $get): bool => $get('type') !== 4),
////                            Select::make('instructor')
////                                ->label('Instructor')
////                                ->options(User::instructors()->pluck('name', 'id'))
////                                ->live(onBlur: true)
////                                ->required(fn(Get $get): bool => $get('type') == 2),
////                        ])
////                        ->columns(2),
////                    Section::make()
////                        ->schema([
////                            ToggleButtons::make('status')
////                                ->label('Reservation status')
////                                ->options([
////                                    '0' => 'Draft',
////                                    '1' => 'Confirmed',
////                                ])
////                                ->colors([
////                                    '0' => 'info',
////                                    '1' => 'success',
////                                ])
////                                ->inline()
////                                ->required(),
////                            Textarea::make('description')
////                                ->label('Notes')
////                                ->rows(5)
////                        ])
////                        ->columns(2),
////                ])
////                ->columns(2),
////        ];
////        return parent::form($form)
////            ->schema([
////                Wizard::make($this->getSteps())
////                    ->startOnStep($this->getStartStep())
////                    ->cancelAction($this->getCancelFormAction())
////                    ->submitAction($this->getSubmitFormAction())
////                    ->skippable($this->hasSkippableSteps())
////                    ->contained(false),
////            ])
////            ->columns(null);
//    }


    /** This is the advanced version
     * public static function getUserRatings(Get $get): array
     * {
     * $currentUser = User::findOrFail(auth()->user()->id);
     * $aircrafts = Plane::where('active', 1)->get();
     * $selectableAircrafts = array();
     *
     * foreach ($aircrafts as $aircraft) {
     * if ((new CreateReservation)->activityCheckPassed($currentUser, $aircraft)) {
     * if ((new CreateReservation)->ratingCheckPassed($currentUser, $aircraft)) {
     * array_push($selectableAircrafts, $aircraft->callsign);
     * } else {
     * //TODO Show warning dialog for missing rating
     * Notification::make()
     * ->title('Saved successfully')
     * ->body('Placeholder text')
     * ->warning()
     * ->persistent()
     * ->send();
     * }
     * } else {
     * $activityCheckNotPassed = true;
     * debug('false activity');
     * }
     * }
     *
     * if (!(new CreateReservation)->balanceCheckPassed($currentUser)) {
     * //TODO Notification alert no balance
     * $selectableAircrafts = [];
     * $balanceCheckNotPassed = true;
     * }
     *
     * if (!(new CreateReservation)->medicalCheckPassed($currentUser)) {
     * //ToDo Notification alert no medical
     * $selectableAircrafts = [];
     * $medicalCheckNotPassed = true;
     * }
     *
     * return $selectableAircrafts;
     * }
     **/
//    public function activityCheckPassed(User $user, Plane $plane): bool
//    {
//        if (Parameter::where('slug', 'check.activities')->value('value') == Parameter::CHECK_ACTIVITIES_ENABLED) {
//            $activities = Activity::where('user_id', $user->id)
//                ->where('plane_id', $plane->id)
//                ->orderBy('event', 'DESC')
//                ->first('event');
//
//            if (!empty($activities->event)) {
//                $expDate = Carbon::now()->subDays(Parameter::where('slug', 'check.activities.limit.days')->value('value'));
//                if (Carbon::createFromFormat(config('panel.date_format'), $activities->event)->format('Y-m-d') <= $expDate) {
//                    return false;
//                }
//            }
//            return true;
//        }
//        return true;
//    }
//
//    public function ratingCheckPassed(User $user, Plane $plane): bool
//    {
//        if (Parameter::where('slug', 'check.ratings')->value('value') == Parameter::CHECK_RATINGS_ENABLED) {
//            if ($user->planes()->where('plane_id', $plane->id)->exists()) {
//                return true;
//            } else {
//                return false;
//            }
//        }
//        return false;
//    }


}
