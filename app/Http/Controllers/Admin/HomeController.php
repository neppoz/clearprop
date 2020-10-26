<?php

namespace App\Http\Controllers\Admin;

use App\Booking;
use App\Services\StatisticsService;
use App\User;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class HomeController
{
    public function index(Request $request)
    {
        $statistics = (new StatisticsService())->dashboard($request);

        $bookings = Booking::with(['plane', 'bookingUsers', 'bookingInstructors'])
            ->where('reservation_start', '>=', Carbon::parse(today()))
            ->orderBy('reservation_start')
            ->get();

        $userMedicals = User::whereNotNull('medical_due')
//            ->whereBetween('medical_due', [
//                Carbon::parse(today())->addMonths(12),
//                Carbon::parse(today())->subMonths(12)
//                ])
            ->orderBy('medical_due', 'desc')
            ->get();

        return view('home', compact('statistics', 'bookings', 'userMedicals'));
    }


//        $chart_options = [
//            'chart_title' => trans('cruds.dashboard.title_linechart_chart'),
//            // 'chart_height' => '100',
//            'chart_type' => 'line',
//            'report_type' => 'group_by_date',
//            'model' => 'App\Activity',
//
//            'conditions' => [
//                [
//                    'name' => 'Minutes',
//                    'condition' => '',
//                    'color' => '#5bc0de',
//                    // 'backgroundColor' => 'grey',
//                    // 'fill' => 'origin',
//                ],
//            ],
//
//            'group_by_field' => 'event',
//            'group_by_field_format' => 'd.m.Y',
//            'group_by_period' => 'month',
//
//            'aggregate_function' => 'sum',
//            'aggregate_field' => 'minutes',
//
//            'filter_field' => 'event',
//            'filter_period' => 'year',
//            //'continuous_time' => true,
//        ];
//
//        $fromMonth = Carbon::parse(sprintf(
//            '%s-%s-01',
//            request()->query('y', Carbon::now()->year),
//            request()->query('m', Carbon::now()->month)
//        ));
//        $from = Carbon::parse(sprintf(
//            '%s-01-01',
//            request()->query('y', Carbon::now()->year)
//        ));
//        $to      = clone $fromMonth;
//        $to->day = $to->daysInMonth;
//
//        $fromDate = Carbon::parse($from)->format('Y-m-d');
//        $toDate = Carbon::parse($to)->format('Y-m-d');
//        session([
//            'fromDate' => $fromDate,
//            'toDate' => $toDate,
//        ]);


}
