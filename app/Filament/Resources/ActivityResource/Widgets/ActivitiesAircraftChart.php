<?php

namespace App\Filament\Resources\ActivityResource\Widgets;

use App\Services\StatisticsService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class ActivitiesAircraftChart extends ApexChartWidget
{
    protected static ?string $pollingInterval = null;

    protected int|string|array $columnSpan = 'full';

    protected static ?string $chartId = 'activitiesAircraftChart';

    /**
     * Sort
     */
    protected static ?int $sort = 2;
    /**
     * Widget content height
     */
    protected static ?int $contentHeight = 250;

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */
    protected function getOptions(): array
    {
        $user = Auth::user();
        $stacked = false;

        if ($user && $user->is_instructor && !$user->is_admin && !$user->is_manager) {
            $statistics = (new StatisticsService())->getInstructorMonthlyActivityHours($user, 6);
            $stacked = true;
        } else {
            $statistics = (new StatisticsService())->getActivitiesByAircraft(6);
        }

        $categories = collect($statistics['categories'])->map(function ($monthNumber) {
            return Carbon::createFromDate(
                Carbon::now()->year,
                (int) $monthNumber,
                1
            )->shortMonthName;
        })->toArray();

        $tailwindBlues = [
//            '#bfdbfe', // blue-200
//            '#93c5fd', // blue-300
            '#60a5fa', // blue-400
//            '#3b82f6', // blue-500
//            '#2563eb', // blue-600
//            '#1d4ed8', // blue-700
            '#1e40af', // blue-800
            '#1e3a8a', // blue-900
        ];

        $colors = [];
        $gradientToColors = [];

        foreach ($statistics['series'] as $index => $label) {
            $colorIndex = $index % count($tailwindBlues);
            $colors[] = $tailwindBlues[$colorIndex];

            $nextColorIndex = ($colorIndex + 4) % count($tailwindBlues);
            $gradientToColors[] = $tailwindBlues[$nextColorIndex];
        }

        return [
            'chart' => [
                'type' => 'bar',
                'height' => 240,
                'parentHeightOffset' => 2,
                'stacked' => $stacked,
                'toolbar' => [
                    'show' => false,
                ],
            ],
            'series' => $statistics['series'],
            'xaxis' => [
                'categories' => $categories,
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'yaxis' => [
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'fill' => [
                'type' => 'gradient',
                'gradient' => [
                    'shade' => 'dark',
                    'type' => 'vertical',
                    'shadeIntensity' => 0.5,
                    'gradientToColors' => $gradientToColors,
                    'opacityFrom' => 1,
                    'opacityTo' => 2,
                    'stops' => [0, 100],
                ],
            ],
            'stroke' => [
                'curve' => 'smooth',
                'width' => 1,
                'lineCap' => 'round',
            ],
            'colors' => $colors,
            'plotOptions' => [
                'bar' => [
                    'borderRadius' => 2,
                    'horizontal' => false,
                ],
            ],
            'dataLabels' => [
                'enabled' => false,
            ],
        ];
    }

    public function getHeading(): ?string
    {
        return __('panel.totalHoursByMonth');
    }


}
