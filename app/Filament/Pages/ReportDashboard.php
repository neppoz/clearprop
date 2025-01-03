<?php

namespace App\Filament\Pages;

use App\Filament\Resources\IncomeResource;
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

    public static function getWidgets(): array
    {
        return [
            \App\Filament\Resources\IncomeResource\Widgets\BalanceOverview::class,
            IncomeResource\Widgets\BalanceOverview::class,
        ];
    }

//    public static function getColumns(): int
//    {
//        return 2; // Anzahl der Spalten für Widgets
//    }


}
