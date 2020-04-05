<?php

namespace App\Http\Controllers\Admin;

use App\Activity;
use App\Http\Controllers\Controller;
use Gate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ActivityReportController extends Controller
{
    public function index()
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

        $fromSelectedDate = Carbon::parse($from)->format(config('panel.date_format'));
        $toSelectedDate = Carbon::parse($to)->format(config('panel.date_format'));

        $activities = Activity::with(['user'])
            ->whereBetween('event', [$from, $to]);

        $activityAmount = $activities->sum('amount');
        $activityMinutes = $activities->sum('minutes');
        $activityTotalTime = intval($activityMinutes / 60) .':'. $activityMinutes%60;
        $groupedActivities = $activities->whereNotNull('user_id')->orderBy('minutes', 'desc')->get()->groupBy('user_id');

        $activitiesSummary = [];

        foreach ($groupedActivities as $act) {
            foreach ($act as $line) {
                if (!isset($activitiesSummary[$line->user->name])) {
                    $activitiesSummary[$line->user->name] = [
                        'name'   => $line->user->name,
                        'minutes' => 0,
                    ];
                }

                $activitiesSummary[$line->user->name]['minutes'] += $line->minutes;
            }
        }


        return view('admin.activityReports.index', compact(
            'activitiesSummary',
            'activityTotalTime',
            'activityAmount',
            'fromSelectedDate',
            'toSelectedDate'
        ));
    }
}
