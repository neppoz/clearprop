<?php

namespace App\Http\Controllers\Admin;

use App\Services\Statistics;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;
use Carbon\Carbon;

class HomeController
{
    public function index()
    {
        $chart_options = [
            'chart_title' => trans('cruds.dashboard.title_linechart_chart'),
            'chart_height' => '90',
            'chart_type' => 'line',
            'report_type' => 'group_by_date',
            'model' => 'App\Activity',

            'conditions' => [
                [
                    'name' => 'Minutes',
                    'condition' => '',
                    'color' => '#5bc0de',
                    // 'backgroundColor' => 'grey',
                    // 'fill' => 'origin',
                ],
            ],

            'group_by_field' => 'event',
            'group_by_field_format' => 'd.m.Y',
            'group_by_period' => 'month',

            'aggregate_function' => 'sum',
            'aggregate_field' => 'minutes',

            'filter_field' => 'event',
            'filter_period' => 'year',
            //'continuous_time' => true,
        ];

        $statistics = (new Statistics())->dashboard();
        $chart1 = new LaravelChart($chart_options);

        return view('home', compact('chart1', 'statistics'));
    }
}
