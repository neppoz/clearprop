<?php

namespace App\Filament\Pages\Widgets;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Widgets\Widget;

class FilterWidget extends Widget implements HasForms
{
    use InteractsWithForms;

    protected static string $view = 'filament.widgets.filter-widget';
    protected static bool $isLazy = false;

    public $startDate;
    public $endDate;

    public function mount(): void
    {
        $this->startDate = now()->startOfYear()->toDateString();
        $this->endDate = now()->endOfYear()->toDateString();

        $this->form->fill([
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
        ]);
    }

    protected function getFormSchema(): array
    {
        return [
            Grid::make(2)
                ->schema([
                    DatePicker::make('startDate')
                        ->label('Start Date')
                        ->default(now()->startOfYear()->toDateString())
                        ->reactive()
                        ->afterStateUpdated(fn() => $this->updatedFilter()),

                    DatePicker::make('endDate')
                        ->label('End Date')
                        ->default(now()->endOfYear()->toDateString())
                        ->reactive()
                        ->afterStateUpdated(fn() => $this->updatedFilter()),
                ]),
        ];
    }

    public function updatedFilter(): void
    {
        $data = $this->form->getState();

        $this->dispatch('filterUpdated', $data['startDate'], $data['endDate']);
    }
}
