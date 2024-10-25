<?php

namespace App\Filament\Resources\ActivityResource\Widgets;

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
    protected static ?string $heading = 'Total by type';
    /**
     * Sort
     */
    protected static ?int $sort = 1;

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
        return [
            'chart' => [
                'type' => 'donut',
                'height' => 200,
                'toolbar' => [
                    'show' => false,
                ],
            ],
            'series' => [78, 22, 5],
            'labels' => ['Charter', 'School', 'Maintenance'],
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
                    'gradientToColors' => ['#60a5fa', '#1d4ed8', '#082f49'],
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
            'colors' => ['#93c5fd', '#2563eb', '#1d4ed8'],
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
