<?php

namespace App\Filament\Resources\ActivityResource\Widgets;

use App\Services\StatisticsService;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class ActivitiesAircraftChart extends ApexChartWidget
{
    protected static ?string $pollingInterval = null;
    /**
     * Chart Id
     *
     * @var string
     */
    protected static ?string $chartId = 'activitiesAircraftMinutesChart';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'Total hours by month';

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
        $statistics = (new StatisticsService())->getActivitiesByAircraft();

        $tailwindBlues = [
//            '#bfdbfe', // blue-200
//            '#93c5fd', // blue-300
            '#60a5fa', // blue-400
            '#3b82f6', // blue-500
            '#2563eb', // blue-600
            '#1d4ed8', // blue-700
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
        debug($statistics['series']);
        return [
            'chart' => [
                'type' => 'bar',
                'height' => 240,
                'parentHeightOffset' => 2,
                'stacked' => true,
                'toolbar' => [
                    'show' => false,
                ],
            ],
            'series' => $statistics['series'],
            'xaxis' => [
                'categories' => $statistics['categories'],
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
}
