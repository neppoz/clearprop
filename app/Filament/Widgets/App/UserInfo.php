<?php

namespace App\Filament\Widgets\App;

use App\Services\ReservationValidator;
use App\Services\StatisticsService;
use App\Settings\GeneralSettings;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class UserInfo extends Widget
{
    protected static ?int $sort = 1;
    protected static ?string $pollingInterval = null;
    protected static bool $isLazy = false;
    protected static string $view = 'filament.widgets.user-info';
    public bool $hasValidMedical = false;
    public ?string $medicalDueDate = null;
    public bool $hasValidBalance = false;
    public ?float $userBalance = null;
    public string $balanceStatusColor = 'success';
    public bool $isBalanceCheckActive = false;
    protected int|string|array $columnSpan = 'full';

    public static function canView(): bool
    {
        return Auth::check() && Auth::user()->is_member;
    }

    public function mount(): void
    {
        $user = Auth::user();

        $this->hasValidMedical = ReservationValidator::validateMedical($user);
        $this->medicalDueDate = $user->medical_due?->format('d/m/Y');

        $this->hasValidBalance = ReservationValidator::validateBalance($user);
        $this->userBalance = (new StatisticsService())->validateBalanceCalculation($user);

        $settings = app(GeneralSettings::class);
        $this->isBalanceCheckActive = $settings->check_balance;

        if ($settings->check_balance) {
            $limit = $settings->check_balance_limit_amount;

            $warnZoneStart = $limit + 100; // Static value

            if ($this->userBalance < $limit) {
                $this->balanceStatusColor = 'danger';
            } elseif ($this->userBalance < $warnZoneStart) {
                $this->balanceStatusColor = 'warning';
            } else {
                $this->balanceStatusColor = 'success';
            }
        } else {

            $this->balanceStatusColor = 'success';
        }
    }

}
