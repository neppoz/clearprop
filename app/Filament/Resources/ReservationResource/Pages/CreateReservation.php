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
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\CreateRecord\Concerns\HasWizard;
use Illuminate\Support\HtmlString;

class CreateReservation extends CreateRecord
{
    use HasWizard;

    protected static string $resource = ReservationResource::class;

    public function form(Form $form): Form
    {
        return parent::form($form)
            ->schema([
                Wizard::make($this->getSteps())
                    ->startOnStep($this->getStartStep())
                    ->cancelAction($this->getCancelFormAction())
                    ->submitAction($this->getSubmitFormAction())
                    ->skippable($this->hasSkippableSteps())
                    ->contained(false),
            ])
            ->columns(null);
    }

    /** @return Step[] */
    protected function getSteps(): array
    {
        return [
            Step::make('Aircraft & Crew')
                ->schema([
                    Section::make()
                        ->schema([
                            Radio::make('Reservation type')
                                ->options([
                                    1 => 'Charter',
                                    2 => 'School',
                                    4 => 'Maintenance'
                                ])
                                ->inline()
                                ->required(),
                            Select::make('aircraft')
                                ->label('Aircraft')
                                ->options(fn(Get $get) => self::getUserRatings($get))
                                ->live(onBlur: true)
                                ->required(),
                        ])
                        ->columns(1),

                    Section::make()
                        ->schema([
                            // ToDo: The logic to display dynamically
                            Placeholder::make('noMedical')
                                ->label('Your medical is expired!')
                                ->content(new HtmlString('Medical..'))
                                ->visible(),
                            Placeholder::make('noBalance')
                                ->label('Your balance is critical')
                                ->content(new HtmlString('Balance..'))
                                ->visible(),
                        ])
                        ->columnSpan(['lg' => 1]),
                ]),

            Step::make('Date & Time')
                ->schema([

                ]),
            
            Step::make('Review')
                ->schema([

                ]),
        ];
    }

    public static function getUserRatings(Get $get): array
    {
        $currentUser = User::findOrFail(auth()->user()->id);
        $aircrafts = Plane::where('active', 1)->get();
        $selectableAircrafts = array();

        foreach ($aircrafts as $aircraft) {
            if ((new CreateReservation)->activityCheckPassed($currentUser, $aircraft)) {
                if ((new CreateReservation)->ratingCheckPassed($currentUser, $aircraft)) {
                    array_push($selectableAircrafts, $aircraft->callsign);
                } else {
                    //TODO Show warning dialog for missing rating
                    debug('false rating');
                }
            } else {
                $activityCheckNotPassed = true;
                debug('false activity');
            }
        }

        if (!(new CreateReservation)->balanceCheckPassed($currentUser)) {
            //TODO Notification alert no balance
            $selectableAircrafts = [];
            $balanceCheckNotPassed = true;
        }

        if (!(new CreateReservation)->medicalCheckPassed($currentUser)) {
            //ToDo Notification alert no medical
            $selectableAircrafts = [];
            $medicalCheckNotPassed = true;
        }

        return $selectableAircrafts;
    }

    public function activityCheckPassed(User $user, Plane $plane): bool
    {
        if (Parameter::where('slug', 'check.activities')->value('value') == Parameter::CHECK_ACTIVITIES_ENABLED) {
            $activities = Activity::where('user_id', $user->id)
                ->where('plane_id', $plane->id)
                ->orderBy('event', 'DESC')
                ->first('event');

            if (!empty($activities->event)) {
                $expDate = Carbon::now()->subDays(Parameter::where('slug', 'check.activities.limit.days')->value('value'));
                if (Carbon::createFromFormat(config('panel.date_format'), $activities->event)->format('Y-m-d') <= $expDate) {
                    return false;
                }
            }
            return true;
        }
        return true;
    }

    public function ratingCheckPassed(User $user, Plane $plane): bool
    {
        if (Parameter::where('slug', 'check.ratings')->value('value') == Parameter::CHECK_RATINGS_ENABLED) {
            if ($user->planes()->where('plane_id', $plane->id)->exists()) {
                return true;
            } else {
                return false;
            }
        }
        return false;
    }

    public function balanceCheckPassed(User $user): bool
    {
        if (Parameter::where('slug', 'check.balance')->value('value') == Parameter::CHECK_BALANCE_ENABLED) {
            $activities = Activity::where('user_id', $user->id)
                ->whereBetween('event', [now()->startOfYear(), now()])
                ->get('amount');

            $incomes = Income::whereHas('income_category', function ($q) {
                $q->where('deposit', '=', 1);
            })
                ->where('user_id', $user->id)
                ->whereBetween('entry_date', [now()->startOfYear(), now()])
                ->get('amount');

            $balance = ($incomes->sum('amount') - abs($activities->sum('amount')));
            if ($balance <= Parameter::where('slug', 'check.balance.limit.amount')->value('value')) {
                return false;
            }

        }
        return true;
    }

    private function medicalCheckPassed(User $user): bool
    {
        if (Parameter::where('slug', 'check.medical')->value('value') == Parameter::CHECK_MEDICAL_ENABLED) {
            if (empty($user->medical_due)) {
                return false;
            }
            if (!empty($user->medical_due) && Carbon::createFromFormat(config('panel.date_format'), $user->medical_due)->format('Y-m-d') <= now()) {
                return false;
            }
        }
        return true;
    }

    protected function afterCreate(): void
    {
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
    }


}
