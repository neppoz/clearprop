<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\UserEmail;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Mail;
use App\User;
use App\Activity;
use App\Income;
use Gate;
use Carbon\Carbon;
use niklasravnsborg\LaravelPdf\Facades\Pdf;

class UsersReportController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');


        $from = Carbon::createFromFormat(config('panel.date_format'), $request->activityfrom)->format('Y-m-d');
        $to = Carbon::createFromFormat(config('panel.date_format'), $request->activityto)->format('Y-m-d');

        $usersWithActivities = User::whereHas('userActivities', function ($query) use($from, $to){
            $query->whereBetween('event', [$from, $to]);
        })->get('id');

        foreach ($usersWithActivities as $userid) {

            $user_details = User::select('name', 'email')
                ->where('id', '=', $userid->id)
                ->get();
            $to_addr = $user_details[0]->email;
            $to_name = $user_details[0]->name;
            $report_name = $to.'_'.$to_name.'_'.uniqid();
            $path = storage_path('tmp/reports');
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }


            $activity_lines = Activity::select('event', 'counter_start', 'counter_stop', 'rate', 'minutes', 'amount')
                ->where('user_id', '=', $userid->id)
                ->whereBetween('event', [$from, $to])
                ->get();
            ;
            $activityAmountTotal = $activity_lines->sum('amount');
            $activityMinutesTotal = $activity_lines->sum('minutes');
            $activityHoursAndMinutes = intval($activityMinutesTotal / 60) . ':' . $activityMinutesTotal%60;


            $income_lines = Income::whereHas('income_category', function($q) {
                $q->where('deposit', '=', 1);
                })
                ->whereBetween('entry_date', [$from, $to])
                ->where('user_id', '=',$userid->id)
                ->get();
            $incomeAmountTotal = $income_lines->sum('amount');


            $granTotal = $incomeAmountTotal + -abs($activityAmountTotal);

            $pdf = Pdf::loadView('reports.members', compact(
                'report_name',
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

            $bcc_addr = '';
            $bcc_name = '';
            $subject = 'Report: ' . $report_name;
            $attachment = $path.'/'.$report_name.'.pdf';
            Mail::send(new UserEmail($subject, $to_addr, $to_name, $bcc_addr, $bcc_name, $attachment));

        }

        return back();

    }

}
