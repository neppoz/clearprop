<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\UserReport;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Mail;
use App\User;
use App\Activity;
use App\Income;
use Gate;
use Carbon\Carbon;
use niklasravnsborg\LaravelPdf\Facades\Pdf;
use RealRashid\SweetAlert\Facades\Alert;

class UsersReportController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->session()->has('fromSelectedDate') && $request->session()->has('toSelectedDate')) {
            $from = Carbon::createFromFormat(config('panel.date_format'), $request->session()->get('fromSelectedDate'))->format('Y-m-d');
            $to = Carbon::createFromFormat(config('panel.date_format'), $request->session()->get('toSelectedDate'))->format('Y-m-d');

            $usersWithActivities = User::whereHas('userActivities', function ($query) use ($from, $to) {
                $query->whereBetween('event', [$from, $to]);
            })->get('id');

            foreach ($usersWithActivities as $userid) {
                $user_details = User::select('name', 'email')
                    ->where('id', '=', $userid->id)
                    ->get();

                $report_name = $to.'_'.$user_details[0]->name.'_'.uniqid();
                $path = storage_path('tmp/reports');
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }

                $activity_lines = Activity::select('event', 'counter_start', 'counter_stop', 'rate', 'minutes', 'amount')
                    ->where('user_id', '=', $userid->id)
                    ->whereBetween('event', [$from, $to])
                    ->get();

                $activityAmountTotal = $activity_lines->sum('amount');
                $activityMinutesTotal = $activity_lines->sum('minutes');
                $activityHoursAndMinutes = intval($activityMinutesTotal / 60) . ':' . $activityMinutesTotal%60;


                $income_lines = Income::whereHas('income_category', function ($q) {
                    $q->where('deposit', '=', 1);
                })
                    ->whereBetween('entry_date', [$from, $to])
                    ->where('user_id', '=', $userid->id)
                    ->get();
                $incomeAmountTotal = $income_lines->sum('amount');


                $granTotal = $incomeAmountTotal + -abs($activityAmountTotal);

                $pdf = Pdf::loadView('reports.members', compact(
                    'user_details',
                    'activity_lines',
                    'income_lines',
                    'activityMinutesTotal',
                    'activityHoursAndMinutes',
                    'activityAmountTotal',
                    'incomeAmountTotal',
                    'granTotal'
                ));

                $pdf->save($path.'/'.$report_name.'.pdf');

                $attachment = $path.'/'.$report_name.'.pdf';
                Mail::send(new UserReport($user_details, $attachment));
                return back()->withToastSuccess(trans('global.sweetalert_success_sendreport'));
            }
        } else {
            return back()->withToastError(trans('global.sweetalert_error_sendreport'));
        }
    }
}
