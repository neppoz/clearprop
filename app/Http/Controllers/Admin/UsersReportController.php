<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use App\User;
use App\Jobs\UserDataReportJob;
use Gate;
use Throwable;
use Carbon\Carbon;

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
            })->get();

            $sender = auth()->user();

            foreach ($usersWithActivities as $user) {
                try {
                    UserDataReportJob::dispatch($user, $from, $to, $sender);
                } catch (Throwable $exception) {
                    report($exception);
                    return back()->withToastError($exception->getMessage());
                }
            }
            return back()->withToastSuccess(trans('global.sweetalert_success_sendreport'));
        } else {
            return back()->withToastError(trans('global.sweetalert_error_sendreport'));
        }
    }

    public function individualReport($user)
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user = User::findOrFail($user);

        $sender = auth()->user();

        try {
            UserDataReportJob::dispatch($user, now()->startOfYear(), now(), $sender);
            return back()->withToastSuccess(trans('global.sweetalert_success_sendreport'));
        } catch (Throwable $exception) {
            report($exception);
            return back()->withToastError($exception->getMessage());
        }
    }
}
