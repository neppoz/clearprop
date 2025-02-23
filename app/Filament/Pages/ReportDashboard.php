<?php

namespace App\Filament\Pages;

use App\Filament\Pages\Widgets\FilterWidget;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Gate;

class ReportDashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?int $navigationSort = 5;

    protected static string $view = 'filament.pages.report-dashboard';

    public static function shouldRegisterNavigation(): bool
    {
        return Gate::allows('viewReports');
    }

    public static function canView(): bool
    {
        return Gate::allows('viewReports');
    }

    public function getHeaderWidgets(): array
    {
        return [
            FilterWidget::class,
            Widgets\PaymentOverview::class,
            Widgets\BalanceOverview::class,
        ];
    }

    public function getHeaderWidgetsColumns(): int
    {
        return 2;
    }

}
