<?php

namespace App\Filament\Resources\ActivityResource\Widgets;

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
    protected static ?string $heading = 'Total hours';

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
            'series' => [
                [
                    'name' => 'IA918',
                    'data' => [7, 10, 13, 15, 18],
                ],
                [
                    'name' => 'IC001',
                    'data' => [7, 2, 1, 5, 3],
                ],
            ],
            'xaxis' => [
                'categories' => [
                    'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec',
                ],
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
                    'gradientToColors' => ['#60a5fa', '#1d4ed8'],
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
            'colors' => ['#93c5fd', '#2563eb'],
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
