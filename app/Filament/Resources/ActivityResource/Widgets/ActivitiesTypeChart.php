<?php

namespace App\Filament\Resources\ActivityResource\Widgets;

use App\Services\StatisticsService;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class ActivitiesTypeChart extends ApexChartWidget
{
    protected static ?string $pollingInterval = null;
    /**
     * Chart Id
     *
     * @var string
     */
    protected static ?string $chartId = 'activitiesTypeChart';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'Activities by type';
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
        $statistics = (new StatisticsService())->getActivitiesByType();

        $tailwindBlues = [
//            '#bfdbfe', // blue-200
//            '#93c5fd', // blue-300
//            '#60a5fa', // blue-400
            '#3b82f6', // blue-500
//            '#2563eb', // blue-600
//            '#1d4ed8', // blue-700
            '#1e40af', // blue-800
            '#1e3a8a', // blue-900
        ];

        $colors = [];
        $gradientToColors = [];

        foreach ($statistics['labels'] as $index => $label) {
            $colorIndex = $index % count($tailwindBlues);
            $colors[] = $tailwindBlues[$colorIndex];

            $nextColorIndex = ($colorIndex + 4) % count($tailwindBlues);
            $gradientToColors[] = $tailwindBlues[$nextColorIndex];
        }

        return [
            'chart' => [
                'type' => 'donut',
                'height' => 200,
                'toolbar' => [
                    'show' => false,
                ],
            ],
            'series' => $statistics['series'],
            'labels' => $statistics['labels'],
            'legend' => [
                'labels' => [
                    'fontFamily' => 'inherit',
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
                'enabled' => true,
            ],
        ];
    }
}
