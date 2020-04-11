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

        $activities = Activity::with(['user', 'type', 'plane'])
            ->whereBetween('event', [$from, $to]);

        $activityTotalMinutes = $activities->sum('minutes');
        $activityTotalTime = intval($activityTotalMinutes / 60) .':'. $activityTotalMinutes%60;

        /* Activity by member */
        $groupedUserActivities = $activities->whereNotNull('user_id')->orderBy('minutes', 'desc')->get()->groupBy('user_id');
        $activitiesUserSummary = [];

        foreach ($groupedUserActivities as $act) {
            foreach ($act as $line) {
                if (!isset($activitiesUserSummary[$line->user->name])) {
                    $activitiesUserSummary[$line->user->name] = [
                        'name'   => $line->user->name,
                        'minutes' => 0
                    ];
                }

                $activitiesUserSummary[$line->user->name]['minutes'] += $line->minutes;
            }
        }

        /* Activity by type */
        $groupedTypeActivities = $activities->whereNotNull('type_id')->orderBy('minutes', 'desc')->get()->groupBy('type_id');
        $activitiesTypeSummary = [];

        foreach ($groupedTypeActivities as $act) {
            foreach ($act as $line) {
                if (!isset($activitiesTypeSummary[$line->type->name])) {
                    $activitiesTypeSummary[$line->type->name] = [
                        'name'   => $line->type->name,
                        'minutes' => 0,
                    ];
                }

                $activitiesTypeSummary[$line->type->name]['minutes'] += $line->minutes;
            }
        }

        /* Activity by plane */
        $groupedPlaneActivities = $activities->whereNotNull('plane_id')->orderBy('minutes', 'desc')->get()->groupBy('plane_id');
        $activitiesPlaneSummary = [];

        foreach ($groupedPlaneActivities as $act) {
            foreach ($act as $line) {
                if (!isset($activitiesPlaneSummary[$line->plane->callsign])) {
                    $activitiesPlaneSummary[$line->plane->callsign] = [
                        'callsign'   => $line->plane->callsign,
                        'minutes' => 0,
                    ];
                }

                $activitiesPlaneSummary[$line->plane->callsign]['minutes'] += $line->minutes;
            }
        }

        return view('admin.activityReports.index', compact(
            'activitiesUserSummary',
            'activitiesTypeSummary',
            'activitiesPlaneSummary',
            'activityTotalMinutes',
            'activityTotalTime',
            'fromSelectedDate',
            'toSelectedDate'
        ));
    }
}
