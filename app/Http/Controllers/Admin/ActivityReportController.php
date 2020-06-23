<?php

namespace App\Http\Controllers\Admin;

use App\Activity;
use App\Http\Controllers\Controller;
use Gate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use RealRashid\SweetAlert\Facades\Alert;
use App\Services\StatisticsService;

class ActivityReportController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('activity_report_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $fromMonth = Carbon::parse(sprintf(
            '%s-%s-01',
            request()->query('y', Carbon::now()->year),
            request()->query('m', Carbon::now()->month)
        ));
        $from = Carbon::parse(sprintf(
            '%s-01-01',
            request()->query('y', Carbon::now()->year)
        ));
        $to      = clone $fromMonth;
        $to->day = $to->daysInMonth;

        $fromDate = Carbon::parse($from)->format('Y-m-d');
        $toDate = Carbon::parse($to)->format('Y-m-d');
        session([
            'fromDate' => $fromDate,
            'toDate' => $toDate,
        ]);

        $fromSelectedDate = Carbon::parse($from)->format(config('panel.date_format'));
        $toSelectedDate = Carbon::parse($to)->format(config('panel.date_format'));

        /** Invoke Service Class */
        $statistics = (new StatisticsService())->getActivityReport($request);
        
        session([
            'fromSelectedDate' => $fromSelectedDate,
            'toSelectedDate' => $toSelectedDate,
        ]);


        return view('admin.activityReports.index', [
            'activitiesUserSummary' => $statistics['activitiesUserSummary'],
            'activitiesTypeSummary' => $statistics['activitiesTypeSummary'],
            'activitiesPlaneSummary' => $statistics['activitiesPlaneSummary'],
            'activityTotalMinutes' => $statistics['activityTotalMinutes'],
            'activityTotalTime' => $statistics['activityTotalTime']
        ], compact(
            'fromSelectedDate',
            'toSelectedDate'
        ))->withSuccess('global.sweetalert_success_sendreport');
    }
}
